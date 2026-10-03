<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'subscription_id' => null,
            'reference' => 'INV-'.Str::upper(Str::random(10)),
            'amount' => fake()->randomElement([99, 199, 399]),
            'method' => fake()->randomElement(PaymentMethod::cases()),
            'status' => PaymentStatus::Paid,
            'paid_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
