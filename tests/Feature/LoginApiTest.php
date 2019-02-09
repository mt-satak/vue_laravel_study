<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        // テストユーザ作成
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_登録済みのユーザを認証して返す()
    {
        $response = $this->json('POST', route('login'), [
            'email'    => $this->user->email,
            'password' => 'secret',
        ]);

        $response->assertStatus(200)->assertJson(['name' => $this->user->name]);

        $this->assertAuthenticatedAs($this->user);
    }
}
