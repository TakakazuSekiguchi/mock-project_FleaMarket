<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'buyer_id' => User::factory(),
            'payment_method' => 1,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル101',
        ];
    }
    
    //カード決済
    public function card()
    {
        return $this->state(fn () => [
            'payment_method' => 1,
        ]);
    }

    //コンビニ決済
    public function konbini()
    {
        return $this->state(fn () => [
            'payment_method' => 0,
        ]);
    }
}
