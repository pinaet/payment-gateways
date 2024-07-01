<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\MailsController;
use Illuminate\Support\Facades\View;
use Mockery;
use App\Order;
use App\Endpoint;
use App\SourceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Faker\Factory as Faker;

class OrdersControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $ordersController;
    protected $faker;
    protected $mock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ordersController = new OrdersController();
        $this->faker = Faker::create();
        $this->mock = Mockery::mock();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGenOrder()
    {
        // Create necessary database records
        $endpoint = Endpoint::factory()->create();
        SourceType::factory()->create();

        // Prepare test data with all required fields
        $payload = [
            'endpoint_id' => $endpoint->id,
            'amount' => 100.00,
            'currency' => 'USD',
            'description' => $this->faker->sentence,
            'reference_order' => 'REF' . $this->faker->numberBetween(100, 999),
            'customer_name' => $this->faker->name,
            'customer_email' => $this->faker->email,
        ];

        // Convert payload to JSON string
        $jsonPayload = json_encode($payload);

        // Create a request with the payload
        $request = new Request();
        $request->headers->set('Content-Type', 'application/json');
        $request->initialize(['order' => $jsonPayload]);

        // Replace the global request instance
        $this->app->instance('request', $request);

        // Mock the View facade
        $mockView = Mockery::mock('Illuminate\View\View');
        $mockView->shouldReceive('getName')->andReturn('pages.order-index');

        View::shouldReceive('make')
            ->once()
            ->with('pages.order-index', Mockery::type('array'), [])
            ->andReturn($mockView);

        // Call the method
        $response = $this->ordersController->genOrder($request);

        // Assert the response
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertEquals('pages.order-index', $response->getName());

        // Assert that the order was created in the database
        $this->assertDatabaseHas('orders', [
            'endpoint_id' => $endpoint->id,
            'amount' => 100.00,
            'currency' => 'USD',
            'description' => $payload['description'],
            'reference_order' => $payload['reference_order'],
            'customer_name' => $payload['customer_name'],
            'customer_email' => $payload['customer_email'],
        ]);

        // Retrieve the created order
        $createdOrder = Order::latest('id')->first();

        // Assert that the order was created with the correct data
        $this->assertNotNull($createdOrder, 'No order was created');
        $this->assertEquals($endpoint->id, $createdOrder->endpoint_id);
        $this->assertEquals(100.00, $createdOrder->amount);
        $this->assertEquals('USD', $createdOrder->currency);
        $this->assertEquals($payload['description'], $createdOrder->description);
        $this->assertEquals($payload['reference_order'], $createdOrder->reference_order);
        $this->assertEquals($payload['customer_name'], $createdOrder->customer_name);
        $this->assertEquals($payload['customer_email'], $createdOrder->customer_email);
    }


    public function testUpdateSourceType()
    {
        // Prepare test data
        $order = Order::factory()->create([
            'id' => 1,
            'total_amount' => 50.00,
            'source_type_id' => null,
            'source_type' => null,
            'transaction_id' => null,
            'status' => 'c',
        ]);

        $orderData = [
            'id' => 1,
            'source_type_id' => 2,
            'source_type' => 'credit_card'
        ];

        $payloadData = [
            'amount' => 75.00
        ];

        // Create a request with the payload
        $request = new Request();
        $request->headers->set('Content-Type', 'application/json');
        $request->initialize([
            'order' => json_encode($orderData),
            'payload' => json_encode($payloadData)
        ]);

        // Replace the global request instance
        $this->app->instance('request', $request);

        // Call the method
        $response = $this->ordersController->updateSourceType();

        // Assert the response
        $this->assertEquals('200 OK', $response->getContent());

        // Assert the order was updated in the database
        $this->assertDatabaseHas('orders', [
            'id' => 1,
            'total_amount' => 75.00,
            'source_type_id' => 2,
            'source_type' => 'credit_card',
            'transaction_id' => 0,
            'status' => 'p',
        ]);
    }

    public function testUpdateOrder()
    {
        // Prepare test data
        $order = Order::factory()->create([
            'id' => 1,
            'ref' => '1.12345',
            'status' => 'p',
            'transaction_id' => null,
        ]);

        $data = [
            'transaction_id' => 58,
            'ref' => '1.12345',
            'amount' => '1.02',
            'currency' => 'THB',
            'description' => 'Awesome Product',
            'source_type' => 'alipay',
            'reference_order' => '12345',
            'payment_status' => 'completed',
        ];

        // Call the method
        $updatedOrder = $this->ordersController->updateOrder($data);

        // Assert the order was updated correctly
        $this->assertEquals('c', $updatedOrder->status);
        $this->assertEquals(58, $updatedOrder->transaction_id);

        // Assert the order was updated in the database
        $this->assertDatabaseHas('orders', [
            'id' => 1,
            'ref' => '1.12345',
            'status' => 'c',
            'transaction_id' => 58,
        ]);
    }

    // Add more tests for other methods...
}
