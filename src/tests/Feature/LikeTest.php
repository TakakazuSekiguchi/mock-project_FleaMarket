<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねアイコンを押下するといいねした商品として登録される()
    {
        // Arrange（準備）
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // Act（実行）
        $response = $this->actingAs($user)
            ->post(route('items.like', $item->id));

        // Assert（検証）
        $response->assertStatus(302);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_いいねアイコンを押下すると色が変化する()
    {
        // Arrange
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // Act① 詳細ページを表示（前提確認）
        $this->actingAs($user)
            ->get(route('items.show', $item->id))
            ->assertStatus(200);

        // Act② いいねボタンを押す（POST）
        $this->actingAs($user)
            ->post(route('items.like', $item->id))
            ->assertStatus(302);

        // Act③ 再度 詳細ページを表示
        $response = $this->actingAs($user)
            ->get(route('items.show', $item->id));

        // Assert
        $response->assertStatus(200);

        $response->assertSee(
            asset('images/heart-logo_pink.png'),
            false
        );
    }

    public function test_再度いいねアイコンを押下すると、いいねが解除されていいねの件数が減る()
    {
        // Arrange
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // ① いいね（1回目押下）
        $this->actingAs($user)
            ->post(route('items.like', $item->id))
            ->assertStatus(302);

        // DB確認：いいねがある
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // ② もう一度押す（いいね解除）
        $this->actingAs($user)
            ->post(route('items.like', $item->id))
            ->assertStatus(302);

        // DB確認：いいねが消えている
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // ③ 詳細ページを再表示
        $response = $this->actingAs($user)
            ->get(route('items.show', $item->id));

        // ④ 表示確認
        $response->assertStatus(200);

        // アイコンがデフォルトに戻る
        $response->assertSee(
            asset('images/heart-logo_default.png'),
            false
        );

        // いいね数が 0 になっている
        $response->assertSee(
            '<p class="like__count">0</p>',
            false
        );
    }
}