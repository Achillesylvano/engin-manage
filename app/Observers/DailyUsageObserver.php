<?php

namespace App\Observers;

use App\Events\DailyUsageCreated;
use App\Models\DailyUsage;
use App\Services\AlertMaintenanceService;

class DailyUsageObserver
{
    /**
     * Handle the DailyUsage "created" event.
     */
    public function created(DailyUsage $dailyUsage): void
    {
        event(new DailyUsageCreated($dailyUsage));
    }

    /**
     * Handle the DailyUsage "updated" event.
     */
    public function updated(DailyUsage $dailyUsage): void
    {
        $engin = $dailyUsage->engin()->first();

        if (! $engin) {
            return;
        }

        $compteur_h = $dailyUsage->compteur_h_retour ?? $engin->compteur_h;
        $compteur_km = $dailyUsage->compteur_km_retour ?? $engin->compteur_km;

        if ($compteur_h != $engin->compteur_h || $compteur_km != $engin->compteur_km) {
            $engin->update([
                'compteur_h' => $compteur_h,
                'compteur_km' => $compteur_km,
            ]);
        }

        // Vérification des seuils
        $engin->refresh();
        // (new AlertMaintenanceService)->checkSeuil($dailyUsage);
        app(AlertMaintenanceService::class)->checkSeuil($dailyUsage);
        event(new \App\Events\DailyUsageUpdated($dailyUsage));

    }

    /**
     * Handle the DailyUsage "deleted" event.
     */
    public function deleted(DailyUsage $dailyUsage): void
    {
        //
    }

    /**
     * Handle the DailyUsage "restored" event.
     */
    public function restored(DailyUsage $dailyUsage): void
    {
        //
    }

    /**
     * Handle the DailyUsage "force deleted" event.
     */
    public function forceDeleted(DailyUsage $dailyUsage): void
    {
        //
    }
}
