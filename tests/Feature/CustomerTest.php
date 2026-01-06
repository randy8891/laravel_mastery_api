<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_customers()
    {
        $user = \App\Models\User::factory()->create();

        //authenticate user using sanctum
        $this->actingAs($user, 'sanctum');

        Customer::factory()->count(3)->create();

        $response = $this->getJson('/api/customers');

        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_store_creates_customer()
    {
        $data = [
            'name' => 'Acme Corp',
            'email' => 'contact@acme.test',
            'phone' => '123-456-7890',
            'address' => '123 Main St',
        ];

        $user = \App\Models\User::factory()->create();

        //authenticate user usinf sanctum
        $this->actingAs($user,'sanctum');

        $response = $this->postJson('/api/customers', $data);

        $response->assertStatus(201)->assertJsonFragment(['email' => 'contact@acme.test']);
        $this->assertDatabaseHas('customers', ['email' => 'contact@acme.test']);
    }

    public function test_show_returns_customer()
    {
        $user = \App\Models\User::factory()->create();

        //authenticate user using sanctum
        $this->actingAs($user, 'sanctum');

        $customer = Customer::factory()->create();

        $response = $this->getJson('/api/customers/' . $customer->id);

        $response->assertStatus(200)->assertJson(['id' => $customer->id]);
    }

    public function test_update_modifies_customer()
    {

        $user = \App\Models\User::factory()->create();

        //authenticate user using sanctum
        $this->actingAs($user, 'sanctum');

        $customer = Customer::factory()->create();

        $response = $this->putJson('/api/customers/' . $customer->id, ['name' => 'Updated Name']);

        $response->assertStatus(200)->assertJson(['name' => 'Updated Name']);
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Updated Name']);
    }

    public function test_destroy_deletes_customer()
    {

        $user = \App\Models\User::factory()->create();

        //authenticate user using sanctum
        $this->actingAs($user, 'sanctum');

        $customer = Customer::factory()->create();

        $response = $this->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
