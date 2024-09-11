<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditCard>
 */
class CreditCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => ClientFactory::new(),
            'card_type' => $this->faker->randomElement(['Visa', 'AMEX']),
            'bank_name' => $this->faker->company,
            'card_number' => $this->faker->unique()->randomNumber(8),
            'limit' => $this->faker->randomFloat(2, 1, 1000),
            'available_limit' => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}
