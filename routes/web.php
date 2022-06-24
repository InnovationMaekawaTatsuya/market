<?php

// ログイン関係
Auth::routes();

// この中の処理は全てミドルウェアがきく
Route::middleware('auth')->group(function () {
    // items関連
    Route::resource('items', 'ItemController');
    Route::name('items.')->group(function () {
        // トップページ
        Route::get('/', 'ItemController@top')->name('top');
        // 検索機能
        Route::post('/items/search-item', 'ItemController@search')->name('search');
        // 商品画像編集関連
        Route::get('/items/{item}/edit-image', 'ItemController@editImage')->name('edit_image');
        Route::patch('/items/{item}/edit-image', 'ItemController@updateImage')->name('update_image');
        // 商品購入関連
        Route::patch('/items/{item}/order-confirm', 'ItemController@orderConfirm')->name('order_confirm');
        Route::patch('/items/{item}/ordered', 'ItemController@ordered')->name('orderd');
        // お気に入り更新
        // Route::patch('/items/{item}/toggle-like', 'ItemController@toggleLike')->name('toggle_like');
    });

    // users関連
    Route::name('users.')->group(function () {
        Route::get('/user-images/{user}/edit-image', 'UserController@editImage')->name('edit_image');
        Route::patch('/user-images/edit-image', 'UserController@updateImage')->name('update_image');
    });
    Route::resource('users', 'UserController')->only([
        'show', 'edit', 'update'
    ]);

    // likes関連
    Route::name('likes.')->group(function(){
        Route::get('/like/{like}/likes', 'LikeController@index')->name('index');
    });

    // likes関連
    Route::name('likes.')->group(function(){
        Route::post('/ajaxlike', 'ItemController@ajaxlike')->name('ajaxlike');
    });
});