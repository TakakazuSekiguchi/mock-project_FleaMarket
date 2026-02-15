<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Item;
use App\Models\User;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            // 出品者
            'user_id' => User::factory(),

            // 商品状態
            'condition' => $this->faker->numberBetween(1, 4),

            // 商品名
            'name' => $this->faker->lexify(str_repeat('?', 20)),

            // 価格
            'price' => $this->faker->numberBetween(500, 50000),

            // ステータス（0:出品中, 1:購入済み）
            'status' => 0,

            // ブランド（任意）
            'brand' => $this->faker->optional()->company(),

            // 商品説明
            'description' => $this->faker->realText(100),

            // 画像（ダミー）
            'image' => 'dummy.jpg',
        ];
    }
    
    public function sold()
    {
        return $this->state(function () {
            return [
                'status' => 1,
                // 'buyer_id' => User::factory(),
            ];
        });
    }
}

