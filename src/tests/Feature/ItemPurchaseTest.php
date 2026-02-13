<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use Mockery;
use Stripe\Event;

class ItemPurchaseTest extends TestCase
{
    use RefreshDatabase;

    //Mockeryを使用している場合は必ず記述する
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_「購入する」ボタンを押下すると購入が完了する()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'buyer_id' => null,
            'status' => 0,
        ]);

        //Stripe Eventを作成
        $fakeEvent = Event::constructFrom([
            'type' => 'payment_intent.succeeded',
            'data' => [
                'object' => [
                    'metadata' => [
                        'item_id' => $item->id,
                        'buyer_id' => $buyer->id,
                        'payment_method' => 1,
                        'postal_code' => '123-4567',
                        'address'     => '東京都渋谷区1-2-3',
                        'building'    => 'テストビル101',
                    ],
                ],
            ],
        ]);

        // aliasモック
        Mockery::mock('alias:Stripe\Webhook')
            ->shouldReceive('constructEvent')
            ->once()
            ->andReturn($fakeEvent);

        $response = $this->postJson(route('stripe.webhook'), []);
        
        $response->assertStatus(200);

        // items更新確認
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'buyer_id' => $buyer->id,
            'status' => 1,
        ]);

        // purchases作成確認
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'payment_method' => 1,
            'postal_code' => '123-4567',
            'address'     => '東京都渋谷区1-2-3',
            'building'    => 'テストビル101',
        ]);
    }

    public function test_購入済み商品は商品一覧でSoldと表示される()
    {
        // Arrange（準備）
        $seller = User::factory()->create();
        $buyer  = User::factory()->create();
        $viewer = User::factory()->create();

        $soldItem = Item::factory()->create([
            'user_id'  => $seller->id,
            'buyer_id'=> $buyer->id,
            'status'  => 1, // 購入済み
            'name'    => 'テスト商品',
        ]);

        // Act（実行）
        // 購入者以外（出品者を除く）が見てもSold表示となっているか確認する為、$viewerでログインして表示
        $response = $this->actingAs($viewer)
            ->get(route('items.index'));

        // Assert（検証）
        $response->assertStatus(200);

        // 「Sold」表示されているか
        $response->assertSee('Sold');
        $response->assertSee('テスト商品');
    }

    public function test_購入した商品がプロフィールの購入商品一覧に表示される()
    {
        // Arrange
        $seller = User::factory()->create();
        $buyer  = User::factory()->create();

        $item = Item::factory()->create([
            'user_id'  => $seller->id,
            'buyer_id' => $buyer->id,
            'status'   => 1,
            'name'     => 'テスト商品',
        ]);

        // 購入履歴（Purchase）を作成することで、
        // 「購入した商品一覧」は Purchase を正として表示される仕様を前提にする
        Purchase::factory()
            ->card()
            ->create([
                'item_id'   => $item->id,
                'buyer_id'  => $buyer->id,
                'seller_id' => $seller->id,
            ]);

        // Act
        $response = $this->actingAs($buyer)
            ->get(route('mypage.buy'));

        // Assert
        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }
}
