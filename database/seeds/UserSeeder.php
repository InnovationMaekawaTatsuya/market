<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 1000; $i++) {
                User::insert([
                'email' => $i . '@' . $i,
                'profile' => $i . '番目のユーザーのプロフィール文章です。',
                'name' => 'ユーザー' . $i,
                'image' => 'photos/NNOEyl8uu3jo3X6SeK5qh7eUbYSZEkrhL3eS1BuG.png',
                'password' => 'password' . $i,
          ]);
        }
    }
}
