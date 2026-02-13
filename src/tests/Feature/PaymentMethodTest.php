<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use Stripe\Checkout\Session;
// use Mockery;

//支払方法の選択について、JSを使用し小計画面表示をしている為、
//カード払いとコンビニ支払がそれぞれStripeに渡せているか、を確認することで代替
class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    //Mockeryを使用している場合は必ず記述する
    //PurchaseController側でStripeServiceを使用することになったので、この記述は不要
    // protected function tearDown(): void
    // {
    //     Mockery::close();
    //     parent::tearDown();
    // }

    public function test_カード払いの場合は「card」がStripeに渡される()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        Address::factory()->create([
            'user_id' => $buyer->id,
        ]);

        // $mock = Mockery::mock('alias:' . Session::class);
        // $mock->shouldReceive('create')
        //     ->once()
        //     ->with(Mockery::on(function ($params) {
        //         return $params['payment_method_types'] === ['card'];
        //     }))
        //     ->andReturn((object)[
        //         'url' => 'https://stripe.test/card',
        //     ]);

        $this->mock(\App\Services\StripeService::class)
            ->shouldReceive('createSession')
            ->once()
            ->with(Mockery::on(function ($params) {
                return $params['payment_method_types'] === ['card'];
            }))
            ->andReturn((object)[
                'url' => 'https://stripe.test/card',
            ]);

        $response = $this->actingAs($buyer)->post(
            route('purchase.checkout', $item),
            ['payment_method' => 1]
        );

        $response->assertRedirect('https://stripe.test/card');
    }

    public function test_コンビニ支払の場合は「konbini」がStripeに渡される()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        Address::factory()->create([
            'user_id' => $buyer->id,
        ]);

        // $mock = Mockery::mock('alias:' . Session::class);
        // $mock->shouldReceive('create')
        //     ->once()
        //     ->with(Mockery::on(function ($params) {
        //         return $params['payment_method_types'] === ['konbini'];
        //     }))
        //     ->andReturn((object)[
        //         'url' => 'https://stripe.test/konbini',
        //     ]);

        $this->mock(\App\Services\StripeService::class)
            ->shouldReceive('createSession')
            ->once()
            ->with(Mockery::on(function ($params) {
                return $params['payment_method_types'] === ['konbini'];
            }))
            ->andReturn((object)[
                'url' => 'https://stripe.test/konbini',
            ]);

        $response = $this->actingAs($buyer)->post(
            route('purchase.checkout', $item),
            ['payment_method' => 0]
        );

        $response->assertRedirect('https://stripe.test/konbini');
    }
}
