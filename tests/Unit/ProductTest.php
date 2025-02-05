<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_product()
    {
        $role = Role::firstOrCreate(['name' => 'User']);

        $user = User::factory()->create([
            'name' => "New User",
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/product', [
            'name' => 'Laptop',
            'description' => 'A high-end gaming laptop.',
            'price' => 1999.99,
            'stock' => 5
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'product' => ['id', 'name', 'price', 'stock']
            ]);
    }
    public function test_user_can_fetch_products()
    {
        $role = Role::firstOrCreate(['name' => 'User']);

        $user = User::factory()->create([
            'name' => "New User",
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id
        ]);
        Product::factory()->count(5)->create([
            'name' => 'Laptop',
            'description' => 'A high-end gaming laptop.',
            'price' => 1999.99,
            'stock' => 5,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['id', 'name', 'price', 'stock']]
            ]);
    }
    public function test_user_can_update_product()
    {
        $role = Role::firstOrCreate(['name' => 'User']);

        $user = User::factory()->create([
            'name' => "New User",
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id
        ]);
        $product = Product::factory()->create([
            'name' => 'Laptop',
            'description' => 'A high-end gaming laptop.',
            'price' => 1999.99,
            'stock' => 5,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/product/{$product->id}", [
            'name' => 'Updated Laptop',
            'description' => 'Updated specs.',
            'price' => 2200.99,
            'stock' => 3
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product updated successfully.']);
    }
    public function test_user_can_delete_product()
    {
        $role = Role::firstOrCreate(['name' => 'User']);

        $user = User::factory()->create([
            'name' => "New User",
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id
        ]);
        $product = Product::factory()->create([
            'name' => 'Laptop',
            'description' => 'A high-end gaming laptop.',
            'price' => 1999.99,
            'stock' => 5,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/product/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product deleted successfully.']);
    }
}
