<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public string $site_description;

    public string $site_keywords;

    public string $support_email;

    public string $support_phone;

    public ?string $facebook_url;

    public ?string $twitter_url;

    public ?string $instagram_url;

    public ?string $bank_name;

    public ?string $bank_account_name;

    public ?string $bank_iban;

    public static function group(): string
    {
        return 'general';
    }
}
