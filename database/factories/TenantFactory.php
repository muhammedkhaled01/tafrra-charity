<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'جمعية '.fake('ar_SA')->lastName().' الخيرية',
            'domain' => Str::lower(Str::random(8)).'.tafrra.com',
            'email' => fake()->unique()->safeEmail(),
            'phone' => '05'.fake()->numerify('########'),
            'city' => fake()->randomElement(config('tafrra.cities')),
            'subscription_id' => Subscription::factory(),
            'subscription_expires_at' => now()->addMonths(6),
            'is_active' => true,
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes): array => [
            'subscription_expires_at' => now()->subDay(),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }
}
