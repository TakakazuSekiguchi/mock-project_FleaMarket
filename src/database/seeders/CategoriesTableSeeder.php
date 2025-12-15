<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'id' => 1,
            'category' => 'ファッション'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 2,
            'category' => '家電'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 3,
            'category' => 'インテリア'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 4,
            'category' => 'レディース'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 5,
            'category' => 'メンズ'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 6,
            'category' => 'コスメ'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 7,
            'category' => '本'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 8,
            'category' => 'ゲーム'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 9,
            'category' => 'スポーツ'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 10,
            'category' => 'キッチン'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 11,
            'category' => 'ハンドメイド'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 12,
            'category' => 'アクセサリー'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 13,
            'category' => 'おもちゃ'
        ];
        DB::table('categories')->insert($params);

        $params = [
            'id' => 14,
            'category' => 'ベビー・キッズ'
        ];
        DB::table('categories')->insert($params);
    }
}
