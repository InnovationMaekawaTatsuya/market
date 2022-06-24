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
    public function top(){

        $data = [];
        // ユーザの投稿の一覧を作成日時の降順で取得
        //withCount('テーブル名')とすることで、リレーションの数も取得できます。
        $likes_items = Item::withCount('likes')->orderBy('created_at', 'desc')->get();
        $like_model = new Like;

        $items = Item::withCount('likes')->where('user_id', '!=', \Auth::user()->id)->paginate(10);
        return view('items.top', [
            'title' => 'トップページ',
            'items' => $items,
            'likes_items' => $likes_items,
            'like_model'=>$like_model,
        ]);
    }

    public function index(){
        $items = \Auth::user()->items()->latest()->get();
        return view('items.index', [
            'title' => '商品一覧',
            'items' => $items,
        ]);
    }

    public function search(Request $request){
        // 検索フォームで入力された値を取得
        $search = $request->input('search');
        // クエリビルダ
        $query = Item::query();
        if ($search) {
            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search, 's');
            // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($wordArraySearched as $value) {
                $query->where('name', 'like', '%'.$value.'%');
            }
            // 上記で取得した$queryをページネートにし、変数$usersに代入
            $searched_items = $query->paginate(10);
        }
        return view('items.search', [
            'title' => '検索結果',
            'searched_items' => $searched_items,
        ]);
    }

    public function show(Item $item){
        return view('items.show', [
            'title' => '商品詳細画面',
            'item' => $item,
        ]);
    }

    public function create(){
        $categories = Category::all();
        return view('items.create', [
            'title' => '商品投稿',
            'categories' => $categories,
        ]);
    }

    public function store(ItemRequest $request, FileUploadService $file_service, ItemService $item_service){
        // saveImageクラス呼び出し
        $path = $file_service->saveImage($request->file('image'));
        // createItemクラス呼び出し
        $create_item = $item_service->create_item($request, $path);
        session()->flash('success', '出品が完了しました。');
        return redirect()->route('items.index');
    }

    public function edit(Item $item){
        return view('items.edit', [
            'title' => '商品編集画面',
            'item' => $item,
        ]);
    }

    public function update(ItemTextRequest $request, Item $item){
        $item->update($request->only(['name', 'description', 'price', 'category_id']));
        session()->flash('success', '商品情報を編集しました。');
        return redirect()->route('items.show', $item);
    }

    public function editImage(Item $item){
        if(\Auth::user()->id === $item->user_id){
            return view('items.edit_image', [
                'title' => '商品画像編集',
                'item' => $item,
            ]);
        }else{
            // 不正な編集が疑われる場合は、リダイレクト処理
            return redirect()->route('items.top');
        }
    }

    public function updateImage(ItemImageRequest $request, Item $item, FileUploadService $service){
        // seviceクラス読み込み（画像パス保存）
        $path = $service->saveImage($request->file('image'));
        // seviceクラス読み込み（画像更新）
        $service->updateImage($item, $path);
        session()->flash('success', '画像を変更しました');
        return redirect()->route('items.show', $item);
    }

    public function destroy(Item $item){
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
    public function orderConfirm(Item $item){
        return view('items.order_confirm', [
            'title' => '購入する商品の情報を確認',
            'item' => $item,
        ]);
    }

    public function ordered(ItemService $service, Item $item){
        $user = \Auth::user();
        $service->ordered_item($item);
        return view('items.ordered', [
            'title' => 'ご購入ありがとうございました',
            'item' => $item,
        ]);
    }

    public function ajaxlike(Request $request)
    {
        $id = \Auth::user()->id;
        $item_id = $request->item_id;
        $like = new Like;
        $item = Item::find($item_id);

        // 空でない（既にいいねしている）なら
        if ($like->like_exist($id, $item_id)) {
            //likesテーブルのレコードを削除
            $like = Like::where('item_id', $item_id)->where('user_id', $id)->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new Like;
            $like->item_id = $request->item_id;
            $like->user_id = \Auth::user()->id;
            $like->save();
        }

        //loadCountとすればリレーションの数を○○_countという形で取得できる（今回の場合はいいねの総数）
        $itemLikesCount = $item->loadCount('likes')->likes_count;

        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。笑
        $json = [
            'itemLikesCount' => $itemLikesCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    }
}