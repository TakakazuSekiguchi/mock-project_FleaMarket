<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\User;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::where('email', 'user1@example.com')->firstOrFail();
        $user2 = User::where('email', 'user2@example.com')->firstOrFail();

        $params = [
            'user_id' => $user1->id,
            'condition' => 1,
            'name' => '腕時計',
            'price' => 15000,
            'status' => 0,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image' => 'items/Armani+Mens+Clock.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => $user1->id,
            'condition' => 1,
            'name' => 'HDD',
            'price' => 5000,
            'status' => 0,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image' => 'items/HDD+Hard+Disk.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => $user1->id,
            'condition' => 1,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'status' => 0,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image' => 'items/iLoveIMG+d.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => $user1->id,
            'condition' => 4,
            'name' => '革靴',
            'price' => 4000,
            'status' => 0,
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'image' => 'items/Leather+Shoes+Product+Photo.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => $user1->id,
            'condition' => 1,
            'name' => 'ノートPC',
            'price' => 45000,
            'status' => 0,
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'image' => 'items/Living+Room+Laptop.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => $user2->id,
            'condition' => 2,
            'name' => 'マイク',
            'price' => 8000,
            'status' => 0,
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image' => 'items/Music+Mic+4632231.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => $user2->id,
            'condition' => 2,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'status' => 0,
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'image' => 'items/Purse+fashion+pocket.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => $user2->id,
            'condition' => 4,
            'name' => 'タンブラー',
            'price' => 500,
            'status' => 0,
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'image' => 'items/Tumbler+souvenir.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => $user2->id,
            'condition' => 1,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'status' => 0,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image' => 'items/Waitress+with+Coffee+Grinder.jpg'
        ];
        DB::table('items')->insert($params);

        $params = [
            'user_id' => $user2->id,
            'condition' => 4,
            'name' => 'メイクセット',
            'price' => 2500,
            'status' => 0,
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'image' => 'items/外出メイクアップセット.jpg'
        ];
        DB::table('items')->insert($params);
    }
}
