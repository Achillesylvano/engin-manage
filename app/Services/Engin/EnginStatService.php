<?php

namespace App\Services\Engin;

use App\Models\Engin;

class EnginStatService
{
    public function getStats(): array
    {
        $totalEngin = Engin::query()->count();
        $enginOperationnel = Engin::query()->operationnel()->count();
        $enginEnMaintenance = Engin::query()->enMaintenance()->count();
        $enginHorsService = Engin::query()->horsService()->count();

        return [
            'totalEngin' => $totalEngin,
            'enginOperationnel' => $enginOperationnel,
            'enginEnMaintenance' => $enginEnMaintenance,
            'enginHorsService' => $enginHorsService,
        ];

    }
}
