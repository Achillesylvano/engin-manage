<?php

declare(strict_types=1);

namespace App\Enums;

enum IncidentNiveau: string
{
    case MINEUR = 'mineur';
    case MAJEUR = 'majeur';
    case CRITIQUE = 'critique';

    public function label(): string
    {
        return match ($this) {
            self::MINEUR => 'Mineur',
            self::MAJEUR => 'Majeur',
            self::CRITIQUE => 'Critique',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::MINEUR => 'blue',
            self::MAJEUR => 'yellow',
            self::CRITIQUE => 'red',
        };
    }

    public static function values(): array
    {
        return [
            self::MINEUR->value => self::MINEUR->label(),
            self::MAJEUR->value => self::MAJEUR->label(),
            self::CRITIQUE->value => self::CRITIQUE->label(),
        ];
    }
}
