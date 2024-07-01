<?php

namespace Database\Factories;

use App\SourceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SourceTypeFactory extends Factory
{
    protected $model = SourceType::class;

    public function definition()
    {
        return [
            'source_type' => $this->faker->randomElement(['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'alipay', 'wechat']),
            'rate' => $this->faker->randomFloat(4, 0.001, 0.05),
            'bank' => $this->faker->company,
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence,
            'dest_url' => $this->faker->url,
        ];
    }

    /**
     * Indicate that this is a credit card source type.
     */
    public function creditCard()
    {
        return $this->state(function (array $attributes) {
            return [
                'source_type' => 'credit_card',
                'name' => 'Credit Card',
                'description' => 'Payment via credit card',
            ];
        });
    }

    /**
     * Indicate that this is an Alipay source type.
     */
    public function alipay()
    {
        return $this->state(function (array $attributes) {
            return [
                'source_type' => 'alipay',
                'name' => 'Alipay',
                'description' => 'Payment via Alipay',
            ];
        });
    }

    /**
     * Indicate that this is a WeChat Pay source type.
     */
    public function wechatPay()
    {
        return $this->state(function (array $attributes) {
            return [
                'source_type' => 'wechat',
                'name' => 'WeChat Pay',
                'description' => 'Payment via WeChat Pay',
            ];
        });
    }
}
