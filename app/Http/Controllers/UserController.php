<?php

namespace App\Http\Controllers;

// モデル読み込み
use App\User;

// request読み込み
use Illuminate\Http\Request;
use App\Http\Requests\UserTextRequest;
use App\Http\Requests\UserImageRequest;

// serviceクラス読み込み
use App\Services\FileUploadService;

class UserController extends Controller
{
    public function show(User $user)
    {
        // ログイン中のユーザーと一致した時のみプロフィールを表示
        if(\Auth::user()->id === $user->id){
            $orderedItems = $user->orderItems()
                                  ->latest()
                                  ->get();
            return view('users.show', compact('user', 'orderedItems'));
        }else{
            // 一致しない時はトップページにリダイレクト
            return redirect()->route('items.top');
        }
    }

    public function edit(User $user)
    {
        if(\Auth::user()->id === $user->id){
            return view('users.edit', compact('user'));
        }else{
            // 一致しない時はトップページにリダイレクト
            return redirect()->route('top');
        }
    }

    public function update(UserTextRequest $request, User $user)
    {
        $user->update($request->only(['name', 'profile']));
        session()->flash('success', 'プロフィールを更新しました。');
        return redirect()->route('users.show', $user);
    }

    public function editImage(User $user)
    {
        // ログイン中のユーザーと一致した時のみプロフィール画像を編集可能
        if (\Auth::user()->id === $user->id) {
            return view('users.edit_image', compact('user'));
        }else{
            // 一致しない時はトップページにリダイレクト
            return redirect()->route('top');
        }
    }

    public function updateImage(UserImageRequest $request, FileUploadService $service)
    {
        $user = \Auth::user();

        // seviceクラス読み込み（画像パス保存）
        $path = $service->saveImage($request->file('image'));
        // seviceクラス読み込み（画像更新）
        $service->updateImage($user, $path);
        session()->flash('success', '画像を変更しました');
        return redirect()->route('users.show', $user);
    }
}