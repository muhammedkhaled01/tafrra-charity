<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Enums\BeneficiaryCategory;
use App\Enums\BeneficiaryStatus;
use App\Enums\Gender;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ProjectCategory;
use App\Enums\ProjectStatus;
use App\Enums\RoleName;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Carbon\CarbonImmutable;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Generates a large, realistic dataset (charities, thousands of beneficiaries,
 * projects, applications and a year of payments) so dashboards and charts look alive.
 */
class DemoDataSeeder extends Seeder
{
    /**
     * @var list<string>
     */
    private const CHARITY_NAMES = [
        'جمعية البر الخيرية',
        'جمعية إنسان لرعاية الأيتام',
        'جمعية الإحسان الطبية',
        'جمعية طعام الخيرية',
        'جمعية مودة للتنمية الأسرية',
        'جمعية رعاية كبار السن',
        'جمعية بنيان الخيرية للإسكان',
        'جمعية تكافل الخيرية',
        'جمعية سند لدعم الأسر',
        'جمعية نماء للتنمية',
        'جمعية الوفاء الخيرية',
        'جمعية أبناء للأيتام',
        'جمعية حركية لذوي الإعاقة',
        'جمعية كسوة الخيرية',
        'جمعية عطاء النسائية',
        'جمعية الهلال للخدمات الاجتماعية',
        'جمعية زاد الخيرية',
        'جمعية رحمة للرعاية الصحية',
        'جمعية مكارم الأخلاق',
        'جمعية الأمل لمرضى الكلى',
        'جمعية نور للمكفوفين',
        'جمعية أجيال للتعليم',
        'جمعية سقيا الماء',
        'جمعية الخير الشاملة',
        'جمعية دار الرعاية',
        'جمعية البناء الأسري',
        'جمعية همم التطوعية',
        'جمعية ريادة لتمكين الشباب',
    ];

    /**
     * @var array<string, list<string>>
     */
    private const PROJECT_TITLES = [
        'food' => ['سلة رمضان الغذائية', 'إفطار صائم', 'السلة الشهرية', 'بنك الطعام'],
        'education' => ['الحقيبة المدرسية', 'منح التفوق الدراسي', 'دورات اللغة الإنجليزية', 'تأهيل سوق العمل'],
        'healthcare' => ['العلاج الطبي', 'الأجهزة التعويضية', 'غسيل الكلى', 'نظارات طبية للطلاب'],
        'housing' => ['ترميم المنازل', 'سداد الإيجارات', 'تأثيث المساكن', 'مكيفات الصيف'],
        'seasonal' => ['كسوة الشتاء', 'كسوة العيد', 'الأضاحي', 'زكاة الفطر'],
        'cash' => ['المساعدة الشهرية', 'سداد الفواتير', 'فرحة العيد النقدية', 'دعم الأسر المنتجة'],
    ];

    private Generator $faker;

    private CarbonImmutable $now;

    public function run(): void
    {
        $this->faker = fake('ar_SA');
        $this->now = CarbonImmutable::now();

        $subscriptions = Subscription::all()->values();
        $password = Hash::make('123456789');

        foreach (self::CHARITY_NAMES as $index => $charityName) {
            $subscription = $subscriptions[$this->weightedIndex([45, 38, 17])];
            $joinedAt = $this->now->subDays(fake()->numberBetween(30, 390));

            $tenant = Tenant::forceCreate([
                'name' => $charityName,
                'domain' => 'charity'.($index + 1).'.tafrra.com',
                'email' => 'info@charity'.($index + 1).'.org.sa',
                'phone' => '05'.fake()->numerify('########'),
                'city' => fake()->randomElement(config('tafrra.cities')),
                'subscription_id' => $subscription->id,
                'subscription_expires_at' => $this->expiryFor($index),
                'is_active' => ! in_array($index, [9, 21], true),
                'created_at' => $joinedAt,
                'updated_at' => $joinedAt,
            ]);

            $this->seedTeam($tenant, $index, $password, $joinedAt);
            $beneficiaryIds = $this->seedBeneficiaries($tenant, $joinedAt, $subscription);
            $this->seedProjects($tenant, $joinedAt, $beneficiaryIds);
            $this->seedPayments($tenant, $subscription, $joinedAt);
        }
    }

    private function expiryFor(int $index): CarbonImmutable
    {
        return match (true) {
            in_array($index, [5, 14, 23], true) => $this->now->subDays(fake()->numberBetween(3, 40)),
            in_array($index, [2, 11, 17, 26], true) => $this->now->addDays(fake()->numberBetween(3, 25)),
            default => $this->now->addDays(fake()->numberBetween(45, 330)),
        };
    }

    private function seedTeam(Tenant $tenant, int $index, string $password, CarbonImmutable $joinedAt): void
    {
        $admin = User::forceCreate([
            'tenant_id' => $tenant->id,
            'name' => $this->faker->firstNameMale().' '.$this->faker->lastName(),
            'email' => $index === 0 ? 'charity@tafrra.com' : 'admin@charity'.($index + 1).'.org.sa',
            'password' => $password,
            'email_verified_at' => $joinedAt,
            'created_at' => $joinedAt,
            'updated_at' => $joinedAt,
        ]);
        $admin->assignRole(RoleName::CharityAdmin->value);

        $teamSize = fake()->numberBetween(1, 4);

        for ($member = 1; $member <= $teamSize; $member++) {
            $user = User::forceCreate([
                'tenant_id' => $tenant->id,
                'name' => $this->faker->firstName().' '.$this->faker->lastName(),
                'email' => ($index === 0 && $member === 1) ? 'staff@tafrra.com' : 'staff'.$member.'@charity'.($index + 1).'.org.sa',
                'password' => $password,
                'email_verified_at' => $joinedAt,
                'created_at' => $joinedAt->addDays($member * 3),
                'updated_at' => $joinedAt->addDays($member * 3),
            ]);
            $user->assignRole($member === $teamSize && $teamSize > 2 ? RoleName::CharityViewer->value : RoleName::CharityStaff->value);
        }
    }

    /**
     * @return list<int>
     */
    private function seedBeneficiaries(Tenant $tenant, CarbonImmutable $joinedAt, Subscription $subscription): array
    {
        $limit = $subscription->max_beneficiaries === -1 ? 1400 : min($subscription->max_beneficiaries - 20, 900);
        $count = fake()->numberBetween(180, max(200, $limit));
        $daysActive = max(1, (int) $joinedAt->diffInDays($this->now));
        $usedNationalIds = [];
        $rows = [];

        for ($i = 0; $i < $count; $i++) {
            do {
                $nationalId = fake()->randomElement(['1', '1', '1', '2']).fake()->numerify('#########');
            } while (isset($usedNationalIds[$nationalId]));
            $usedNationalIds[$nationalId] = true;

            $gender = fake()->boolean(54) ? Gender::Female : Gender::Male;
            $firstName = $gender === Gender::Male ? $this->faker->firstNameMale() : $this->faker->firstNameFemale();
            // Square root skews registrations toward recent months, producing a growth curve
            $createdAt = $joinedAt->addMinutes((int) (sqrt(fake()->randomFloat(4, 0, 1)) * $daysActive * 1440));

            $rows[] = [
                'tenant_id' => $tenant->id,
                'national_id' => $nationalId,
                'name' => $firstName.' '.$this->faker->firstNameMale().' '.$this->faker->lastName(),
                'gender' => $gender->value,
                'phone' => '05'.fake()->numerify('########'),
                'dob' => fake()->dateTimeBetween('-85 years', '-4 years')->format('Y-m-d'),
                'city' => fake()->boolean(60) ? $tenant->city : fake()->randomElement(config('tafrra.cities')),
                'family_members' => fake()->numberBetween(1, 11),
                'monthly_income' => fake()->randomElement([0, 0, 1200, 1800, 2400, 3000, 3600, 4500, 6000]),
                'category' => fake()->randomElement(BeneficiaryCategory::cases())->value,
                'status' => fake()->randomElement([
                    BeneficiaryStatus::Active, BeneficiaryStatus::Active, BeneficiaryStatus::Active,
                    BeneficiaryStatus::Active, BeneficiaryStatus::UnderReview, BeneficiaryStatus::Inactive,
                ])->value,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('beneficiaries')->insert($chunk);
        }

        return DB::table('beneficiaries')->where('tenant_id', $tenant->id)->pluck('id')->all();
    }

    /**
     * @param  list<int>  $beneficiaryIds
     */
    private function seedProjects(Tenant $tenant, CarbonImmutable $joinedAt, array $beneficiaryIds): void
    {
        $projectCount = fake()->numberBetween(5, 14);

        for ($i = 0; $i < $projectCount; $i++) {
            $category = fake()->randomElement(ProjectCategory::cases());
            $startDate = $joinedAt->addDays(fake()->numberBetween(0, max(1, (int) $joinedAt->diffInDays($this->now) + 30)));
            $endDate = $startDate->addDays(fake()->numberBetween(30, 180));
            $status = match (true) {
                $startDate->isFuture() => ProjectStatus::Planned,
                $endDate->isPast() => ProjectStatus::Completed,
                default => ProjectStatus::Active,
            };

            $projectId = DB::table('projects')->insertGetId([
                'tenant_id' => $tenant->id,
                'title' => fake()->randomElement(self::PROJECT_TITLES[$category->value]).' '.$startDate->year,
                'description' => 'مشروع ضمن برامج '.$tenant->name.' لخدمة الأسر المستحقة في مجال '.$category->label().'، يستهدف تحسين جودة الحياة وتحقيق الاستدامة.',
                'category' => $category->value,
                'budget' => fake()->randomElement([15000, 30000, 50000, 75000, 120000, 200000, 350000]),
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'status' => $status->value,
                'created_at' => $startDate->subDays(10),
                'updated_at' => $startDate->subDays(10),
            ]);

            if ($status === ProjectStatus::Planned) {
                continue;
            }

            $selected = fake()->randomElements($beneficiaryIds, min(count($beneficiaryIds), fake()->numberBetween(20, 140)));
            $pivotRows = array_map(function (int $beneficiaryId) use ($projectId, $startDate, $status): array {
                $appliedAt = $startDate->addDays(fake()->numberBetween(0, 25));
                $applicationStatus = $status === ProjectStatus::Completed
                    ? fake()->randomElement([ApplicationStatus::Approved, ApplicationStatus::Approved, ApplicationStatus::Approved, ApplicationStatus::Rejected])
                    : fake()->randomElement([ApplicationStatus::Approved, ApplicationStatus::Approved, ApplicationStatus::Pending, ApplicationStatus::Pending, ApplicationStatus::Rejected]);

                return [
                    'project_id' => $projectId,
                    'beneficiary_id' => $beneficiaryId,
                    'status' => $applicationStatus->value,
                    'created_at' => $appliedAt,
                    'updated_at' => $appliedAt,
                ];
            }, $selected);

            foreach (array_chunk($pivotRows, 500) as $chunk) {
                DB::table('project_beneficiary')->insert($chunk);
            }
        }
    }

    private function seedPayments(Tenant $tenant, Subscription $subscription, CarbonImmutable $joinedAt): void
    {
        $rows = [];
        $billingDate = $joinedAt;

        while ($billingDate->lte($this->now)) {
            $status = fake()->randomElement([
                PaymentStatus::Paid, PaymentStatus::Paid, PaymentStatus::Paid, PaymentStatus::Paid,
                PaymentStatus::Paid, PaymentStatus::Paid, PaymentStatus::Paid, PaymentStatus::Paid,
                PaymentStatus::Pending, PaymentStatus::Failed,
            ]);

            $rows[] = [
                'tenant_id' => $tenant->id,
                'subscription_id' => $subscription->id,
                'reference' => 'INV-'.$billingDate->format('ym').'-'.Str::upper(Str::random(6)),
                'amount' => $subscription->price,
                'method' => fake()->randomElement(PaymentMethod::cases())->value,
                'status' => $status->value,
                'paid_at' => $status === PaymentStatus::Paid ? $billingDate->addHours(fake()->numberBetween(1, 48)) : null,
                'created_at' => $billingDate,
                'updated_at' => $billingDate,
            ];

            $billingDate = $billingDate->addMonth();
        }

        DB::table('payments')->insert($rows);
    }

    /**
     * Pick an index based on relative weights.
     *
     * @param  list<int>  $weights
     */
    private function weightedIndex(array $weights): int
    {
        $roll = fake()->numberBetween(1, array_sum($weights));

        foreach ($weights as $index => $weight) {
            $roll -= $weight;

            if ($roll <= 0) {
                return $index;
            }
        }

        return 0;
    }
}
