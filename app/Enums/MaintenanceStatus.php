<?php

declare(strict_types=1);

namespace App\Enums;

enum MaintenanceStatus: string
{
    case PLANIFIEE = 'planifiee';
    case EN_COURS = 'en cours';
    case TERMINEE = 'terminee';
    case ANNULEE = 'annulee';

    public function label(): string
    {
        return match ($this) {
            self::PLANIFIEE => 'Planifiée',
            self::EN_COURS => 'En cours',
            self::TERMINEE => 'Terminée',
            self::ANNULEE => 'Annulée',
        };
    }

    public static function values(): array
    {
        return [
            self::PLANIFIEE->value => self::PLANIFIEE->label(),
            self::EN_COURS->value => self::EN_COURS->label(),
            self::TERMINEE->value => self::TERMINEE->label(),
            self::ANNULEE->value => self::ANNULEE->label(),
        ];
    }
}
