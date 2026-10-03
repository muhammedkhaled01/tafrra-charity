<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Planned = 'planned';
    case Active = 'active';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Planned => 'مخطط',
            self::Active => 'جارٍ التنفيذ',
            self::Completed => 'مكتمل',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Planned => 'sky',
            self::Active => 'violet',
            self::Completed => 'emerald',
        };
    }
}
