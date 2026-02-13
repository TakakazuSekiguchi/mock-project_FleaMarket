<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use Mockery;

class AddressChangeTest extends TestCase
{
    use RefreshDatabase;

    //Mockeryを使用している場合は必ず記述する
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_送付先住所変更後の住所が購入画面に表示される()
    {
        // Arrange（準備）
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $addressData = [
            'user_id'     => $buyer->id,
            'postal_code' => '123-4567',
            'address'     => '東京都渋谷区1-2-3',
            'building'    => 'テストビル101',
        ];

        // 住所登録（変更画面で保存された想定）
        Address::create($addressData);

        // Act（実行）
        $response = $this->actingAs($buyer)
            ->get(route('purchase.show', $item->id));

        // Assert（検証）
        $response->assertStatus(200);
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-2-3');
        $response->assertSee('テストビル101');
    }

    public function test_webhookで購入した商品に送付先住所が紐づいて登録される()
    {
        // Arrange
        $buyer  = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'status' => 0,
        ]);

        // Stripeの署名検証をバイパス
        Mockery::mock('alias:Stripe\\Webhook')
            ->shouldReceive('constructEvent')
            ->once()
            ->andReturn((object)[
                'type' => 'payment_intent.succeeded',
                'data' => (object)[
                    'object' => (object)[
                        'metadata' => (object)[
                            'item_id' => $item->id,
                            'buyer_id' => $buyer->id,
                            'payment_method' => 1,
                            'postal_code' => '123-4567',
                            'address' => '東京都渋谷区1-2-3',
                            'building' => 'テストビル101',
                        ],
                    ],
                ],
            ]);

        $this->postJson(route('stripe.webhook'), [], [
            'Stripe-Signature' => 'test-signature',
        ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => 'テストビル101',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'status' => 1,
            'buyer_id' => $buyer->id,
        ]);

        // $address = Address::factory()->create([
        //     'user_id'     => $buyer->id,
        //     'postal_code' => '123-4567',
        //     'address'     => '東京都渋谷区1-2-3',
        //     'building'    => 'テストビル101',
        // ]);

        // // Act
        // $this->actingAs($buyer)->post(
        //     route('purchase.checkout', $item),
        //     ['payment_method' => 1]
        // );

        // // Assert
        // $this->assertDatabaseHas('purchases', [
        //     'buyer_id'    => $buyer->id,
        //     'item_id'     => $item->id,
        //     'postal_code' => '123-4567',
        //     'address'     => '東京都渋谷区1-2-3',
        //     'building'    => 'テストビル101',
        // ]);
    }
}
