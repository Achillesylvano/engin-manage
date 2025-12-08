<?php

declare(strict_types=1);

namespace App\Services\Maintenance;

use App\Models\Maintenance;

class MaintenanceService
{
    public function getMaintenanceCounts(): array
    {
        return [
            'en_retard' => Maintenance::enRetard()->count(),
            'en_cours' => Maintenance::enCours()->count(),
            'a_venir' => Maintenance::aVenir()->count(),
            'terminee' => Maintenance::terminee()->count(),
        ];
    }
}
