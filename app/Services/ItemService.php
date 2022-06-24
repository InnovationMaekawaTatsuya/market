<?php
    namespace App\Services;

    // モデル読み込み
    use App\Item;
    use App\Order;

    class ItemService
    {
        public function create_item($request, $path){
            if ( isset($request) ) {
                Item::create([
                    'user_id' => \Auth::user()->id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'price' => $request->price,
                    'image' => $path, //（ファイルパス保存）
                ]);
            }
        }

        public function ordered_item($item){
            if ( isset($item) ) {
                $order_item = Order::create([
                    'user_id' => $item->user_id,
                    'item_id' => $item->id
                ]);
                return $order_item;
            }
        }
    }