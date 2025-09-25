<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\AlertMaintenanceCreated;
use App\Models\AlertMaintenance;
use App\Models\DailyUsage;

class AlertMaintenanceService
{
    /**
     * Vérifie les seuils de maintenance pour un DailyUsage donné
     * et crée des alertes si nécessaire.
     */
    public function checkSeuil(DailyUsage $dailyUsage): void
    {
        $engin = $dailyUsage->engin;

        if (! $engin) {
            return;
        }

        // Charger toutes les alertes "nouvelle" existantes pour cet engin
        // et combiner maintenance_automatique_id + type pour vérification rapide
        $alertesExistantes = AlertMaintenance::query()
            ->where('engin_id', $engin->id)
            ->where('statut', 'nouvelle')
            ->get(['maintenance_automatique_id', 'type'])
            ->map(fn ($a) => $a->maintenance_automatique_id.'-'.$a->type)
            ->toArray();

        foreach ($engin->maintenancesAutomatiques as $maintenanceAuto) {
            $dernierCompteur = $maintenanceAuto->dernier_compteur;
            $compteurActuel = $maintenanceAuto->type === 'km'
                ? $engin->compteur_km
                : $engin->compteur_h;

            if ($compteurActuel >= $dernierCompteur + $maintenanceAuto->seuil) {
                // Clé unique pour vérifier si l'alerte existe déjà pour ce type
                $key = $maintenanceAuto->id.'-'.$maintenanceAuto->type;

                if (! in_array($key, $alertesExistantes, true)) {
                    // Création de l'alerte
                    $alertMaintenance = AlertMaintenance::create([
                        'engin_id' => $engin->id,
                        'maintenance_automatique_id' => $maintenanceAuto->id,
                        'type' => $maintenanceAuto->type,
                        'statut' => 'nouvelle',
                        'compteur_declencheur' => $compteurActuel,
                    ]);

                    // Diffuser l'événement pour mise à jour temps réel
                    AlertMaintenanceCreated::dispatch($alertMaintenance);

                    // Mise à jour du dernier compteur pour cette maintenance
                    $maintenanceAuto->update([
                        'dernier_compteur' => $compteurActuel,
                    ]);
                }
            }
        }
    }
}
