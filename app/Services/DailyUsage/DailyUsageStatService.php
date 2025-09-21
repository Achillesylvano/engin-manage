<?php

declare(strict_types=1);

namespace App\Services\DailyUsage;

use App\Models\DailyUsage;

class DailyUsageStatService
{
    public function getDailyUsageStats()
    {
        return [
            'sortie_du_jour' => DailyUsage::sortieDuJour()->count(),
            'retour_du_jour' => DailyUsage::retourDuJour()->count(),
            'en_cours' => DailyUsage::enCours()->count(),
        ];
    }
}
