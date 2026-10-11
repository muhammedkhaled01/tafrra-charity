<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'منصة طفرة');
        $this->migrator->add('general.site_description', 'منصة خيرية رائدة لدعم الجمعيات والمستفيدين');
        $this->migrator->add('general.site_keywords', 'تبرع, جمعيات خيرية, منصة طفرة, عمل خيري');
        $this->migrator->add('general.support_email', 'support@tafrra.com');
        $this->migrator->add('general.support_phone', '0500000000');
        $this->migrator->add('general.facebook_url', null);
        $this->migrator->add('general.twitter_url', null);
        $this->migrator->add('general.instagram_url', null);
    }
};
