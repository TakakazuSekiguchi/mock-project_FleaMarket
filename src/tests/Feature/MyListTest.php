<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねした商品だけがマイリストに表示される()
    {
        // ユーザー作成
        $loginUser = User::factory()->create();

        // 商品作成
        $likedItem = Item::factory()->create();
        $notLikedItem = Item::factory()->create();

        // いいね（マイリスト登録）
        Like::create([
            'item_id' => $likedItem->id,
            'user_id' => $loginUser->id,
        ]);

        $response = $this->actingAs($loginUser)->get(route('items.mylist'));
        
        $response->assertStatus(200);
        $response->assertViewHas('likeItems', function ($likeItems) use ($likedItem, $notLikedItem) {
            return $likeItems->pluck('item_id')->contains($likedItem->id)
                && ! $likeItems->pluck('item_id')->contains($notLikedItem->id);
        });
    }

    public function test_購入済み商品はSoldと表示される()
    {
        // ユーザー作成
        $loginUser = User::factory()->create();

        // 商品作成
        $likedItem = Item::factory()->create();

        // いいね（マイリスト登録）
        Like::create([
            'item_id' => $likedItem->id,
            'user_id' => $loginUser->id,
        ]);

        // Arrange（準備）
        $soldItem = Item::factory()->sold()->create([
            'name' => '購入済み商品',
        ]);

        // Act（実行）
        $response = $this->actingAs($loginUser)->get(route('items.mylist'));

        // Assert（検証）
        $response->assertStatus(200);
        $response->assertSee('購入済み商品');
        $response->assertSee('Sold');
    }

    public function test_未認証の場合はマイリストに何も表示されない()
    {
        // 他人のいいねデータを作成
        $otherUser = User::factory()->create();
        $item = Item::factory()->create();

        Like::create([
            'user_id' => $otherUser->id,
            'item_id' => $item->id,
        ]);

        // 未ログインでアクセス
        $response = $this->get(route('items.index', ['tab' => 'mylist']));

        // Viewに渡された likeItems という変数が存在していて、その中身が空であることを確認
        $response->assertStatus(200);
        $response->assertViewHas('likeItems', function ($likeItems) {
            return $likeItems->isEmpty();
        });
    }
}