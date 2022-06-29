<?php

namespace App\Http\Controllers;

// リクエスト読み込み
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemTextRequest;
use App\Http\Requests\ItemImageRequest;

// サービスクラス読み込み
use App\Services\FileUploadService;
use App\Services\ItemService;

// モデル読み込み
use App\Item;
use App\Category;
use App\Like;

class ItemController extends Controller
{
    public function top()
    {
        // ユーザの投稿の一覧を作成日時の降順で取得
        //withCount('テーブル名')とすることで、リレーションの数も取得できます。
        $items = Item::withCount('likes')->where('user_id', '!=', \Auth::user()->id)
                                         ->paginate(10);
        return view('items.top', compact('items'));
    }

    public function index()
    {
        $items = \Auth::user()->items()
                              ->latest()
                              ->get();
        return view('items.index', compact('items'));
    }

    public function search(Request $request)
    {
        // 検索フォームで入力された値を取得
        $search = $request->input('search');
        // クエリビルダ
        $query = Item::query();
        if ($search) {
            // 全角スペースを半角に変換
            $spaceConversion = Item::FilterSpace($search, 's');
            // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
            $wordArraySearched = Item::FilterArray($search, $spaceConversion);
            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($wordArraySearched as $value) {
                $query = Item::FilterRetention($value);
            }
            // 上記で取得した$queryをページネートにし、変数$usersに代入
            $searchedItems = Item::Substitution($query, $search);
        }
        return view('items.search', compact('searchedItems'));
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(ItemRequest $request, FileUploadService $fileService, ItemService $itemService)
    {
        // saveImageクラス呼び出し
        $path = $fileService->saveImage($request->file('image'));
        // createItemクラス呼び出し
        $createItem = $itemService->createItem($request, $path);
        session()->flash('success', '出品が完了しました。');
        return redirect()->route('items.index');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(ItemTextRequest $request, Item $item)
    {
        $item->update($request->only(['name', 'description', 'price', 'category_id']));
        session()->flash('success', '商品情報を編集しました。');
        return redirect()->route('items.show', $item);
    }

    public function editImage(Item $item)
    {
        if(\Auth::user()->id === $item->user_id){
            return view('items.edit_image', compact('item'));
        }else{
            // 不正な編集が疑われる場合は、リダイレクト処理
            return redirect()->route('items.top');
        }
    }

    public function updateImage(ItemImageRequest $request, Item $item, FileUploadService $service)
    {
        // seviceクラス読み込み（画像パス保存）
        $path = $service->saveImage($request->file('image'));
        // seviceクラス読み込み（画像更新）
        $service->updateImage($item, $path);
        session()->flash('success', '画像を変更しました');
        return redirect()->route('items.show', $item);
    }

    public function destroy(Item $item)
    {
        // 商品を投稿したユーザーと編集しようとしているユーザーが一致している時のみ編集可能
        if(\Auth::user()->id === $item->user_id){
            // 画像データを削除
            if($item->image != ''){
                // 画像が空ではなかったら、
                \Storage::disk('public')->delete($item->image);
            }
            $item->delete();
            session()->flash('success', '商品を削除しました');
            return redirect()->route('items.index');
        }else{
            // 不正な編集が疑われる場合は、リダイレクト処理
            return redirect()->route('items.top');
        }
    }

    // 商品購入フォーム取得
    public function orderConfirm(Item $item)
    {
        return view('items.order_confirm', compact('item'));
    }

    public function ordered(ItemService $service, Item $item)
    {
        $user = \Auth::user();
        $service->orderedItem($item);
        return view('items.ordered', compact('item'));
    }

    public function ajaxlike(Request $request)
    {
        $id = \Auth::user()->id;
        $itemId = $request->item_id;
        $like = new Like;
        $item = Item::find($itemId);

        // 空でない（既にいいねしている）なら
        if ($like->like_exist($id, $itemId)) {
            //likesテーブルのレコードを削除
            $like = Like::where('item_id', $itemId)->where('user_id', $id)
                                                    ->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new Like;
            $like->item_id = $request->item_id;
            $like->user_id = \Auth::user()->id;
            $like->save();
        }

        //loadCountとすればリレーションの数を○○_countという形で取得できる（今回の場合はいいねの総数）
        $itemLikesCount = $item->loadCount('likes')
                               ->likes_count;

        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。笑
        $json = [
            'itemLikesCount' => $itemLikesCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    }
}