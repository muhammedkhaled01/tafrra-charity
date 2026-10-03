<?php

namespace Database\Factories;

use App\Enums\BeneficiaryCategory;
use App\Enums\BeneficiaryStatus;
use App\Enums\Gender;
use App\Models\Beneficiary;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Beneficiary>
 */
class BeneficiaryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(Gender::cases());
        $faker = fake('ar_SA');
        $firstName = $gender === Gender::Male ? $faker->firstNameMale() : $faker->firstNameFemale();

        return [
            'tenant_id' => Tenant::factory(),
            'national_id' => fake()->randomElement(['1', '2']).fake()->unique()->numerify('#########'),
            'name' => $firstName.' '.$faker->firstNameMale().' '.$faker->lastName(),
            'gender' => $gender,
            'phone' => '05'.fake()->numerify('########'),
            'dob' => fake()->dateTimeBetween('-80 years', '-5 years'),
            'city' => fake()->randomElement(config('tafrra.cities')),
            'family_members' => fake()->numberBetween(1, 12),
            'monthly_income' => fake()->randomElement([0, 1500, 2500, 3200, 4000, 5500]),
            'category' => fake()->randomElement(BeneficiaryCategory::cases()),
            'status' => fake()->randomElement([BeneficiaryStatus::Active, BeneficiaryStatus::Active, BeneficiaryStatus::Active, BeneficiaryStatus::UnderReview, BeneficiaryStatus::Inactive]),
        ];
    }
}
