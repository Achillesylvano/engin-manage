<?php

namespace App\Enums;

enum EnginStatus: string
{
    case OPERATIONNEL = 'operationnel';
    case EN_MAINTENANCE = 'en_maintenance';
    case HORS_SERVICE = 'hors_service';
    case EN_PANNE = 'en_panne';

    public function label(): string
    {
        return match ($this) {
            self::OPERATIONNEL => 'Opérationnel',
            self::EN_MAINTENANCE => 'En maintenance',
            self::HORS_SERVICE => 'Hors service',
            self::EN_PANNE => 'En panne',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::OPERATIONNEL => 'green',
            self::EN_MAINTENANCE => 'yellow',
            self::HORS_SERVICE => 'red',
            self::EN_PANNE => 'orange',
        };
    }

    public static function values(): array
    {
        return [
            self::OPERATIONNEL->value => self::OPERATIONNEL->label(),
            self::EN_MAINTENANCE->value => self::EN_MAINTENANCE->label(),
            self::HORS_SERVICE->value => self::HORS_SERVICE->label(),
            self::EN_PANNE->value => self::EN_PANNE->label(),
        ];
    }
}
