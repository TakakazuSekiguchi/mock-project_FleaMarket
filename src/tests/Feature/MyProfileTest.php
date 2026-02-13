<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Address;

class MyProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_プロフィール設定画面に変更項目が初期値として過去設定されている()
    {
        // Arrange（準備）
        $user = User::factory()->create([
            'icon' => 'mypage.jpg',
            'name' => 'マイページユーザー',
        ]);
        $addressData = Address::factory()->create([
            'user_id' => $user->id,
        ]);

        // Act（実行）
        $response = $this->actingAs($user)->get(route('profile.edit'));

        // Assert（検証）
        $response->assertStatus(200);
        $response->assertSee('mypage.jpg');
        $response->assertSee('マイページユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-2-3');
        $response->assertSee('テストビル101');
    }
}
