<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Address;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::where('email', 'user1@example.com')->firstOrFail();

        $params = [
            'user_id' => $user1->id,
            'postal_code' => '123-4567',
            'address'     => '東京都渋谷区1-2-3',
            'building'    => 'テストビル101',
        ];
        DB::table('addresses')->insert($params);
    }
}
