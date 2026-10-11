<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.bank_name', 'البنك الأهلي السعودي (SNB)');
        $this->migrator->add('general.bank_account_name', 'مؤسسة طفرة لتقنية المعلومات');
        $this->migrator->add('general.bank_iban', 'SA00 1000 0000 0000 0000 0000');
    }
};
