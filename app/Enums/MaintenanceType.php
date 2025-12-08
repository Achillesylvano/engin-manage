<?php

declare(strict_types=1);

namespace App\Enums;

enum MaintenanceType: string
{
    case PREVENTIVE = 'préventive';
    case CORRECTIVE = 'corrective';

    public function label(): string
    {
        return match ($this) {
            self::PREVENTIVE => 'Préventive',
            self::CORRECTIVE => 'Corrective',
        };
    }

    public static function values(): array
    {
        return [
            self::PREVENTIVE->value => self::PREVENTIVE->label(),
            self::CORRECTIVE->value => self::CORRECTIVE->label(),
        ];
    }
}
