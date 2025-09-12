<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Jobs\NotifyOrderClosed;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class OrdersApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Usamos esto para ver el verdadero error en lugar de un 404
        $this->withoutExceptionHandling();
    }

    public function test_unauthenticated_user_cannot_access_protected_routes(): void
    {
        $this->withExceptionHandling(); // Re-enable exception handling for this test
        $response = $this->getJson('/api/orders');
        $response->assertStatus(401);
    }

    public function test_admin_can_access_orders_api_and_view_all_orders(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Order::factory()->count(15)->create();

        $response = $this->actingAs($admin, 'sanctum')
                         ->getJson('/api/orders');

        $response->assertStatus(200)
                 ->assertJsonCount(10, 'data')
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'title', 'status', 'created_at']
                     ]
                 ]);
    }

    public function test_orders_can_be_filtered_by_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Order::factory()->count(5)->create(['status' => 'done']);
        Order::factory()->count(5)->create(['status' => 'pending']);

        $response = $this->actingAs($admin, 'sanctum')
                         ->getJson('/api/orders?status=done');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data')
                 ->assertJsonFragment(['status' => 'done']);
    }

    public function test_only_admin_can_cancel_an_order(): void
    {
        $this->withExceptionHandling(); // Re-enable exception handling for this test
        $admin = User::factory()->create(['role' => 'admin']);
        $agent = User::factory()->create(['role' => 'agent']);
        $order = Order::factory()->create();

        $responseAgent = $this->actingAs($agent, 'sanctum')
                              ->postJson("/api/orders/{$order->id}/cancel");
        $responseAgent->assertStatus(403);

        $this->withoutExceptionHandling(); // Disable for the admin test
        $responseAdmin = $this->actingAs($admin, 'sanctum')
                              ->postJson("/api/orders/{$order->id}/cancel");
        $responseAdmin->assertStatus(200);
        $this->assertEquals('cancelled', $order->fresh()->status);
    }

    public function test_job_is_dispatched_when_order_is_marked_as_done(): void
    {
        Bus::fake();
        $admin = User::factory()->create(['role' => 'admin']);
        $order = Order::factory()->create();

        $this->actingAs($admin, 'sanctum')
             ->patchJson("/api/orders/{$order->id}/done", ['estimated_cost' => 100.00]);

        Bus::assertDispatched(NotifyOrderClosed::class);
    }
}