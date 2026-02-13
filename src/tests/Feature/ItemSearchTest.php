<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品名で部分一致検索ができる()
    {
        // 検索にヒットする商品
        Item::factory()->create([
            'name' => '腕時計',
        ]);

        // 検索にヒットしない商品
        Item::factory()->create([
            'name' => 'HDD',
        ]);

        // 「時計」で検索
        $response = $this->get(route('items.search', [
            'keyword' => '時計',
        ]));

        // ステータス確認
        $response->assertStatus(200);

        // ヒットする商品は表示される
        $response->assertSee('腕時計');

        // ヒットしない商品は表示されない
        $response->assertDontSee('HDD');
    }

    public function test_検索状態がマイページでも保持される()
    {
        // ユーザー作成
        $loginUser = User::factory()->create();

        // 商品作成
        $likedItem = Item::factory()->create();

        // 検索にヒットする商品
        Item::factory()->create([
            'name' => '腕時計',
        ]);

        // 検索にヒットしない商品
        Item::factory()->create([
            'name' => 'HDD',
        ]);

        // いいね（マイリスト登録）
        Like::create([
            'item_id' => $likedItem->id,
            'user_id' => $loginUser->id,
        ]);

        // 「時計」で検索（おすすめタブ）
        $response = $this->actingAs($loginUser)->get(route('items.search', [
            'keyword' => '時計',
            'tab' => 'recommend',
        ]));

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');

        // 「時計」で検索（マイリストタブ）
        $response = $this->actingAs($loginUser)->get(route('items.search', [
            'keyword' => '時計',
            'tab' => 'mylist',
        ]));

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');
    }
}
