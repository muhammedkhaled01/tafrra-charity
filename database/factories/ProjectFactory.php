<?php

namespace Database\Factories;

use App\Enums\ProjectCategory;
use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-10 months', '+1 month');

        return [
            'tenant_id' => Tenant::factory(),
            'title' => fake()->randomElement(['سلة رمضان', 'كسوة الشتاء', 'الحقيبة المدرسية', 'ترميم المنازل', 'كفالة يتيم', 'العلاج الطبي']).' '.fake()->year(),
            'description' => 'مشروع يهدف إلى خدمة الفئات المستحقة وتحسين جودة حياتهم.',
            'category' => fake()->randomElement(ProjectCategory::cases()),
            'budget' => fake()->randomElement([25000, 50000, 120000, 250000]),
            'start_date' => $startDate,
            'end_date' => (clone $startDate)->modify('+'.fake()->numberBetween(1, 6).' months'),
            'status' => fake()->randomElement(ProjectStatus::cases()),
        ];
    }
}
