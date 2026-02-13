<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Address;
use App\Models\User;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'postal_code' => '123-4567',
            'address'     => '東京都渋谷区1-2-3',
            'building'    => 'テストビル101',
        ];
    }
}
