<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        Subscription::updateOrCreate(
            ['name' => 'الباقة الأساسية'],
            [
                'price' => 99.00,
                'max_beneficiaries' => 500,
                'features' => [
                    'excel_export' => true,
                    'pdf_export' => false,
                    'whatsapp_api' => false,
                ],
            ]
        );

        Subscription::updateOrCreate(
            ['name' => 'الباقة الاحترافية'],
            [
                'price' => 199.00,
                'max_beneficiaries' => 2000,
                'features' => [
                    'excel_export' => true,
                    'pdf_export' => true,
                    'whatsapp_api' => true,
                ],
            ]
        );

        Subscription::updateOrCreate(
            ['name' => 'باقة المؤسسات'],
            [
                'price' => 399.00,
                'max_beneficiaries' => -1, // Unlimited
                'features' => [
                    'excel_export' => true,
                    'pdf_export' => true,
                    'whatsapp_api' => true,
                    'advanced_reports' => true,
                ],
            ]
        );
    }
}
