<?php

namespace App\Observers;

use App\Models\Maintenance;

class MaintenanceObserver
{
    /**
     * Handle the Maintenance "created" event.
     */
    public function created(Maintenance $maintenance): void
    {
        if ($maintenance->alert_maintenance_id) {
            $maintenance->alertMaintenance->update([
                'statut' => 'planifiee',
            ]);
        }
    }

    /**
     * Handle the Maintenance "updated" event.
     */
    public function updated(Maintenance $maintenance): void
    {
        //
    }

    /**
     * Handle the Maintenance "deleted" event.
     */
    public function deleted(Maintenance $maintenance): void
    {
        //
    }

    /**
     * Handle the Maintenance "restored" event.
     */
    public function restored(Maintenance $maintenance): void
    {
        //
    }

    /**
     * Handle the Maintenance "force deleted" event.
     */
    public function forceDeleted(Maintenance $maintenance): void
    {
        //
    }
}
