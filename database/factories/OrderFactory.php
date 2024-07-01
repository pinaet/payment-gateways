<?php

namespace Database\Factories;

use App\Order;
use App\Endpoint;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'currency' => $this->faker->currencyCode,
            'customer_email' => $this->faker->safeEmail,
            'customer_name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'email_sent' => $this->faker->boolean,
            'endpoint_id' => Endpoint::factory(),
            'ref' => $this->faker->unique()->uuid,
            'ref2' => $this->faker->word,
            'ref3' => $this->faker->word,
            'reference_order' => $this->faker->unique()->numberBetween(1000, 9999),
            'source' => $this->faker->word,
            'source_type' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'source_type_id' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['p', 'f', 'c']),
            'total_amount' => function (array $attributes) {
                return $attributes['amount'] + $this->faker->randomFloat(2, 0, 10);
            },
            'transaction_id' => $this->faker->unique()->numberBetween(1000000, 9999999),
        ];
    }
}
