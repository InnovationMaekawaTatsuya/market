<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['name' => '食べ物'],
            ['name' => '日用品'],
            ['name' => '書籍'],
            ['name' => 'ハンドメイド雑貨'],
            ['name' => 'スポーツ'],
            ['name' => 'その他']
      ]);
    }
}
