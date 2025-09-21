<?php

namespace App\Http\Controllers;

use App\Models\AlertMaintenance;
use App\Models\Incident;
use App\Models\Maintenance;
use App\Services\Engin\EnginStatService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $enginStat = (new EnginStatService)->getStats();

        // Récupération des alertes avec relations
        $alertes = AlertMaintenance::with(['engin', 'maintenanceAutomatique'])
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($alerte) {
                $alerte->created_human = $alerte->created_at->diffForHumans();

                return $alerte;
            });

        return Inertia::render('Dashboard', array_merge([
            'incidents' => Incident::with('engin')->latest()->take(5)->get(),
            'maintenances' => Maintenance::with(['engin', 'technicien'])->latest()->take(3)->get(),
            'alert_maintenances' => $alertes,
        ], $enginStat));
    }
}
