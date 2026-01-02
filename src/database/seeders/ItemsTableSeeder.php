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
            'condition' => 1,
            'name' => '腕時計',
            'price' => 15000,
            'status' => 1,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image' => 'Armani+Mens+Clock.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'condition' => 1,
            'name' => 'HDD',
            'price' => 5000,
            'status' => 1,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image' => 'HDD+Hard+Disk.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'condition' => 1,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'status' => 1,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image' => 'iLoveIMG+d.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'condition' => 4,
            'name' => '革靴',
            'price' => 4000,
            'status' => 1,
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'image' => 'Leather+Shoes+Product+Photo.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 1,
            'condition' => 1,
            'name' => 'ノートPC',
            'price' => 45000,
            'status' => 1,
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'image' => 'Living+Room+Laptop.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 2,
            'condition' => 2,
            'name' => 'マイク',
            'price' => 8000,
            'status' => 1,
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image' => 'Music+Mic+4632231.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 2,
            'condition' => 2,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'status' => 1,
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'image' => 'Purse+fashion+pocket.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 2,
            'condition' => 4,
            'name' => 'タンブラー',
            'price' => 500,
            'status' => 1,
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'image' => 'Tumbler+souvenir.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 2,
            'condition' => 1,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'status' => 1,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image' => 'Waitress+with+Coffee+Grinder.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => 2,
            'condition' => 4,
            'name' => 'メイクセット',
            'price' => 2500,
            'status' => 1,
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'image' => '外出メイクアップセット.jpg'
        ];
        DB::table('items')->insert($params);
    }
}
