<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'email' => [ 'The email field is required.' ],
                'password' => [ 'The password field is required.' ],
            ]);
    }

    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'pascal@test.com',
            'password' => bcrypt('password'),
        ]);

        $payload = ['email' => 'pascal@test.com', 'password' => 'password'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);
    }
}
