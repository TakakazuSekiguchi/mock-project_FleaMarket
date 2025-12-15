<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'id' => 1,
            'name' => 'ユーザー1',
            'email' => 'user1@example.com',
            'password' => 'aaaa',
        ];
        DB::table('users')->insert($params);

        $params = [
            'id' => 2,
            'name' => 'ユーザー2',
            'email' => 'user2@example.com',
            'password' => 'bbbb',
        ];
        DB::table('users')->insert($params);

        $params = [
            'id' => 3,
            'name' => 'ユーザー3',
            'email' => 'user3@example.com',
            'password' => 'cccc',
        ];
        DB::table('users')->insert($params);
    }
}
