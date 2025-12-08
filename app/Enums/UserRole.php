<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case TECHNICIEN = 'technicien';
    case RESPONSABLE_FLOTTE = 'responsable_flotte';
    case OPERATEUR = 'operateur';
    case AGENT_SUIVI = 'agent_suivi';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::TECHNICIEN => 'Technicien',
            self::RESPONSABLE_FLOTTE => 'Responsable de flotte',
            self::OPERATEUR => 'Opérateur',
            self::AGENT_SUIVI => 'Agent de suivi',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ADMIN => 'blue',
            self::TECHNICIEN => 'orange',
            self::RESPONSABLE_FLOTTE => 'purple',
            self::OPERATEUR => 'cyan',
            self::AGENT_SUIVI => 'gray',
        };
    }

    public static function values(): array
    {
        return [
            self::ADMIN->value => self::ADMIN->label(),
            self::TECHNICIEN->value => self::TECHNICIEN->label(),
            self::RESPONSABLE_FLOTTE->value => self::RESPONSABLE_FLOTTE->label(),
            self::OPERATEUR->value => self::OPERATEUR->label(),
            self::AGENT_SUIVI->value => self::AGENT_SUIVI->label(),
        ];
    }
}
