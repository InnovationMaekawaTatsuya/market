<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 1000; $i++) {
            Item::insert([
                'name' => '商品' . $i,
                'description' => $i . '番目のユーザーの商品説明です！！！！！！',
                'image' => 'photos/NNkYePkhGLQ2WnjTZ9FEi2BFY6Jux7t3a418e4Px.png',
                'price' => rand(100, 10000),
                'user_id' => rand(1, 1000),
                'category_id' => rand(1, 6),
          ]);
        }
    }
}
