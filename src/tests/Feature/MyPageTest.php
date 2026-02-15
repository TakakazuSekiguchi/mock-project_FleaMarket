<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;

class MyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_マイページに必要なユーザー情報が取得できる()
    {
        // ユーザー作成
        $user = User::factory()->create([
            'name' => 'マイページユーザー',
            'icon' => 'mypage.jpg',
        ]);
        $seller = User::factory()->create();

        // 出品した商品
        $sellingItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品',   
        ]);

        // 購入した商品
        $purchasedItem = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入商品',
            'status' => 1,
        ]);

        // 購入レコードを作成
        Purchase::factory()->create([
            'buyer_id' => $user->id,
            'item_id'  => $purchasedItem->id,
            'payment_method' => 1,
        ]);

        // Act（実行）
        $response = $this->actingAs($user)
            ->get(route('mypage.index'));

        // Assert（検証）
        $response->assertStatus(200);
        $response->assertSee('mypage.jpg');
        $response->assertSee('マイページユーザー');
        $response->assertSee('出品商品');
        $response->assertSee('購入商品');
    }
}
