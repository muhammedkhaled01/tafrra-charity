<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'باقة '.fake()->unique()->word(),
            'price' => fake()->randomElement([99, 199, 399]),
            'max_beneficiaries' => 500,
            'features' => [
                'excel_export' => true,
                'pdf_export' => false,
                'whatsapp_api' => false,
            ],
        ];
    }

    public function unlimited(): static
    {
        return $this->state(fn (array $attributes): array => [
            'max_beneficiaries' => -1,
        ]);
    }
}
