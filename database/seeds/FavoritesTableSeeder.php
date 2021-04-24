<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('favorites')->delete();

        $users = User::pluck('id')->all();
        $numberOfUsers = count($users); // すべてのユーザー

        foreach (Question::all() as $question)
        {
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) // ランダム関数でユーザー数の範囲内で数字を設定
            {
                $user = $users[$i]; // ランダムにユーザーを選ぶ

                $question->favorites()->attach($user);
            }
        }
    }
}