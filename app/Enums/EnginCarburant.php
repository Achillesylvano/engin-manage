<?php

declare(strict_types=1);

namespace App\Enums;

enum EnginCarburant: string
{
    case DIESEL = 'diesel';
    case ESSENCE = 'essence';

    public function label(): string
    {
        return match ($this) {
            self::DIESEL => 'Diesel',
            self::ESSENCE => 'Essence',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DIESEL => 'indigo',
            self::ESSENCE => 'red',
        };
    }

    public static function values(): array
    {
        return [
            self::DIESEL->value => self::DIESEL->label(),
            self::ESSENCE->value => self::ESSENCE->label(),
        ];
    }
}
