<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_全商品を取得できる()
    {
        // Arrange（準備）
        $item1 = Item::factory()->create(['name' => '商品A']);
        $item2 = Item::factory()->create(['name' => '商品B']);

        // Act（実行）
        $response = $this->get(route('items.index'));

        // Assert（検証）
        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertSee('商品B');
    }

    public function test_購入済み商品はSoldと表示される()
    {
        // Arrange（準備）
        $soldItem = Item::factory()->sold()->create([
            'name' => '購入済み商品',
        ]);

        // Act（実行）
        $response = $this->get(route('items.index'));

        // Assert（検証）
        $response->assertStatus(200);
        $response->assertSee('購入済み商品');
        $response->assertSee('Sold');
    }

    public function test_自分が出品した商品は表示されない()
    {
        // Arrange（準備）
        $loginUser = User::factory()->create();
        $otherUser = User::factory()->create();

        // 自分の商品
        $myItem = Item::factory()->create([
            'user_id' => $loginUser->id,
            'name' => '自分の商品',
        ]);

        // 他人の商品
        $otherItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '他人の商品',
        ]);

        // ログイン
        $this->actingAs($loginUser);

        // Act（実行）
        $reqponse = $this->get(route('items.mylist'));

        // Assert（検証）
        $reqponse->assertStatus(200);
        $reqponse->assertDontSee('自分の商品');
        $reqponse->assertSee('他人の商品');
    }
}
