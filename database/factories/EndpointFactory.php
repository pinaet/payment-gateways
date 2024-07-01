<?php

namespace Database\Factories;

use App\Endpoint;
use Illuminate\Database\Eloquent\Factories\Factory;

class EndpointFactory extends Factory
{
    protected $model = Endpoint::class;

    public function definition()
    {
        return [
            'bcc' => $this->faker->safeEmail,
            'charge_fee' => $this->faker->randomElement(['Y', 'N']),
            'cost_per_unit' => $this->faker->randomFloat(2, 0, 100),
            'cost_type' => $this->faker->randomElement(['v', 'c']),
            'description' => $this->faker->text,
            'endpoint_type_id' => $this->faker->numberBetween(1, 10),
            'endpoint_url' => $this->faker->url,
            'footnote' => $this->faker->paragraph,
            'name' => $this->faker->company,
            'notify_url' => $this->faker->url,
            'pay_url' => $this->faker->url,
        ];
    }
}
