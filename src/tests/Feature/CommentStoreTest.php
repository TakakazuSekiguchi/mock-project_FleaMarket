<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class CommentStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン済みのユーザーはコメントを送信できる()
    {
        // Arrange（準備）
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $commentData = [
            'comment' => 'テストコメント',
        ];

        // Act（実行）
        $response = $this->actingAs($user)
            ->post(route('comments.store', $item), $commentData);

        // Assert（検証）
        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);
    }

    public function test_ログイン前のユーザーはコメントを送信できない()
    {
        // Arrange（準備）
        $item = Item::factory()->create();

        $commentData = [
            'comment' => '未ログイン時のコメント',
        ];

        // Act（実行）
        $response = $this->post(route('comments.store', $item), $commentData);

        // Assert（検証）
        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('comments', [
            'comment' => '未ログイン時のコメント',
        ]);
    }

    public function test_コメントが入力されていない場合、バリデーションメッセージが表示される()
    {
        // Arrange（準備）
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $commentData = [
            'comment' => '',
        ];

        // Act（実行）
        $response = $this->actingAs($user)
            ->post(route('comments.store', $item), $commentData);

        // Assert（検証）
        $response->assertStatus(302);
        $response->assertSessionHasErrors('comment');
    }

    public function test_コメントが255字以上の場合、バリデーションメッセージが表示される()
    {
        // Arrange（準備）
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 256文字の文字列を作成
        $overComment = str_repeat('あ', 256);

        $commentData = [
            'comment' => '',
        ];

        // Act（実行）
        $response = $this->actingAs($user)
            ->post(route('comments.store', $item), $commentData);

        // Assert（検証）
        $response->assertStatus(302);
        $response->assertSessionHasErrors('comment');
    }
}
