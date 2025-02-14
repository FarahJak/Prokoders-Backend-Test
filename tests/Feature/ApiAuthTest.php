<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_authentication_for_protected_route()
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(401);
    }

    public function test_it_allows_authenticated_user_to_access_protected_route()
    {
        $adminUser = User::factory()->create([
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($adminUser);

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJson(['message' => 'All Data Retrieved successfully']);
    }
}
