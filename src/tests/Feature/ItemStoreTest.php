<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品出品画面で必要な情報が保存できる()
    {
        // ストレージをフェイク
        Storage::fake('public');

        // 出品ユーザー
        $user = User::factory()->create();

        // カテゴリ（複数想定）
        $categories = Category::factory()->count(2)->create();

        // 画像ファイル
        $image = UploadedFile::fake()->create(
            'item.jpg',
            100,
            'image/jpeg'
        );

        // リクエストデータ
        $data = [
            'condition'    => 1,
            'name'         => 'テスト商品',
            'price'        => 5000,
            'brand'        => 'テストブランド',
            'description'  => 'テスト商品の説明です',
            'image'        => $image,
            'category_ids' => $categories->pluck('id')->toArray(),
        ];

        // 出品リクエスト
        $response = $this->actingAs($user)
            ->post(route('items.store'), $data);

        // リダイレクト確認
        $response->assertRedirect(route('mypage.sell'));

        // itemsテーブルに保存されているか
        $this->assertDatabaseHas('items', [
            'user_id'    => $user->id,
            'condition'  => 1,
            'name'       => 'テスト商品',
            'price'      => 5000,
            'brand'      => 'テストブランド',
            'description'=> 'テスト商品の説明です',
            'status'     => 0,
        ]);

        // 保存された商品取得
        $item = Item::first();

        // 画像が保存されているか
        Storage::disk('public')->assertExists($item->image);

        // 中間テーブル（category_item）に保存されているか
        foreach ($categories as $category) {
            $this->assertDatabaseHas('category_item', [
                'item_id'     => $item->id,
                'category_id' => $category->id,
            ]);
        }
    }
}