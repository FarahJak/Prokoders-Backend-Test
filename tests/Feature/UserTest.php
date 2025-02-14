<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_new_user()
    {
        $adminUser = User::factory()->create([
            'email'    => 'admin1@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($adminUser);

        $userData = [
            'name'                        => 'Farah Jakmery',
            'email'                       => 'farah@gmail.com',
            'password'                    => 'password',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name'  => 'Farah Jakmery',
            'email' => 'farah@gmail.com',
        ]);

        $this->assertNotNull(User::where('email', 'farah@gmail.com')->first()->password);
    }
}
