<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertMaintenanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'engin_id' => $this->engin_id,
            'maintenance_automatique_id' => $this->maintenance_automatique_id,
            'compteur_declencheur' => $this->compteur_declencheur,
            'statut' => $this->statut,
            'type' => $this->type,
            'maintenance_automatique' => MaintenanceAutomatiqueResource::make($this->whenLoaded('maintenanceAutomatique')),
            'engin' => EnginResource::make($this->whenLoaded('engin')),
            'created_human' => $this->created_at->diffForHumans(),
        ];
    }
}
