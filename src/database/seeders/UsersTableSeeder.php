<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ItemsTableSeederで出品者としてuser_idを使用する必要があるため作成
        $params = [
            'name' => 'ユーザー1',
            'email' => 'user1@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('aaaa1111'),
            'icon' => null,
        ];
        DB::table('users')->insert($params);

        $params = [
            'name' => 'ユーザー2',
            'email' => 'user2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('bbbb2222'),
            'icon' => null,
        ];
        DB::table('users')->insert($params);
    }
}
