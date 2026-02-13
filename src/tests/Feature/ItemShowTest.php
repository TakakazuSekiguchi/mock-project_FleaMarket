<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品詳細画面に必要な情報が表示される()
    {
        // Arrange（準備）
        $user = User::factory()->create([
            'name' => 'コメントユーザー',
        ]);

        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'condition' => 1,
            'price' => 1000,
            'description' => 'これはテスト用の商品説明です',
            'image' => 'test.jpg',
        ]);

        // カテゴリ（belongsToMany想定）
        $category = Category::factory()->create([
            'name' => '家電',
        ]);
        $item->categories()->attach($category->id);

        // いいね
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // コメント
        Comment::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'とても良い商品ですね',
        ]);

        // Act（実行）
        $response = $this->get(route('items.show', $item));

        // Assert（検証）
        $response->assertStatus(200);

        // 商品情報
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('良好');
        $response->assertSee('1000');
        $response->assertSee('これはテスト用の商品説明です');

        // カテゴリ
        $response->assertSee('家電');

        // 画像（imgタグやパスが含まれているか）
        $response->assertSee('test.jpg');

        // 件数（withCount）
        $response->assertSee((string) $item->likes_count);
        $response->assertSee((string) $item->comments_count);

        // コメント情報
        $response->assertSee('コメントユーザー');
        $response->assertSee('とても良い商品ですね');
    }

    public function test_複数選択されたカテゴリが表示されている()
    {
        // Arrange
        $item = Item::factory()->create();

        $categories = Category::factory()->createMany([
            ['name' => '家電'],
            ['name' => 'インテリア'],
            ['name' => 'キッチン'],
        ]);

        $item->categories()->attach($categories->pluck('id'));

        // Act
        $response = $this->get(route('items.show', $item));

        // Assert
        $response->assertStatus(200);

        $response->assertSee('家電');
        $response->assertSee('インテリア');
        $response->assertSee('キッチン');
    }
}