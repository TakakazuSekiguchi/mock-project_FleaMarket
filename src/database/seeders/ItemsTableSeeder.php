<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'user_id' => 1,
            'category_id' => 1,
            'condition' => 1,
            'name' => '腕時計',
            'price' => 15000,
            'status' => 1,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 2,
            'category_id' => 2,
            'condition' => 1,
            'name' => 'HDD',
            'price' => 5000,
            'status' => 1,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 3,
            'category_id' => 10,
            'condition' => 1,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'status' => 1,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'category_id' => 1,
            'condition' => 4,
            'name' => '革靴',
            'price' => 4000,
            'status' => 1,
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'category_id' => 2,
            'condition' => 1,
            'name' => 'ノートPC',
            'price' => 45000,
            'status' => 1,
            'brand' => '',
            'description' => '高性能なノートパソコン',
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'category_id' => 2,
            'condition' => 2,
            'name' => 'マイク',
            'price' => 8000,
            'status' => 1,
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'category_id' => 1,
            'condition' => 2,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'status' => 1,
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'category_id' => 1,
            'condition' => 4,
            'name' => 'タンブラー',
            'price' => 500,
            'status' => 1,
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'category_id' => 1,
            'condition' => 1,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'status' => 1,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'category_id' => 2,
            'condition' => 4,
            'name' => 'メイクセット',
            'price' => 2500,
            'status' => 1,
            'brand' => '',
            'description' => '便利なメイクアップセット',
        ];
        DB::table('items')->insert($params);
    }
}
