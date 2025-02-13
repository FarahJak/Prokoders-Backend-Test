<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;  // This trait will ensure the database is reset for each test

    public function testAuthenticatedUserCanCreateNewUser()
    {
        $adminUser = User::factory()->create([
            'email'    => 'admin@example.com',
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
