<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles before running tests
        Role::insert([
            ['name' => 'Admin'],
            ['name' => 'User']
        ]);
    }

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' => 'User'
        ]);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'name', 'email']
            ]);
    }
    public function test_user_can_login()
    {
        $role = Role::firstOrCreate(['name' => 'User']);
        
        $user = User::factory()->create([
            'name' => "New User",
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'user@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'token', 'user']);
    }
    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(422)
            ->assertJson(['message' => 'The provided credentials are incorrect.']);
    }
}
