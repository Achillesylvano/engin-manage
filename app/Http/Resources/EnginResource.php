<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnginResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'designation' => $this->designation,
            'marque' => $this->marque,
            'modele' => $this->modele,
            'numero_serie' => $this->numero_serie,
            'compteur_h' => $this->compteur_h,
            'compteur_km' => $this->compteur_km,
            'seuil_maintenance_h' => $this->seuil_maintenance_h,
            'seuil_maintenance_km' => $this->seuil_maintenance_km,
            'etat' => $this->etat,
            'etat_label' => $this->etat->label(),
            'etat_color' => $this->etat->color(),
            'type_carburant' => $this->type_carburant,
            'type_carburant_label' => $this->type_carburant->label(),
            'carburant_color' => $this->type_carburant->color(),
            'capacite_reservoir' => $this->capacite_reservoir,
            'date_acquisition' => Carbon::parse($this->date_acquisition)->format('Y-m-d'),
            'type_engin' => TypeEnginResource::make($this->whenLoaded('typeEngin')),

            // 'maintenances' => MaintenanceResource::collection($this->whenLoaded('maintenances')),
            // 'daily_usages' => DailyUsageResource::collection($this->whenLoaded('dailyUsages')),
        ];
    }
}
