<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyUsageResource extends JsonResource
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
            'date_usage' => $this->date_usage
                ? \Illuminate\Support\Facades\Date::parse($this->date_usage)->translatedFormat('d/m/Y H:i')
                : null,
            'site_destination' => $this->site_destination,
            'observation_depart' => $this->observation_depart,
            'heure_sortie' => $this->heure_sortie,
            'heure_retour' => $this->heure_retour,
            'is_returned' => $this->is_returned,
            'compteur_h_sortie' => $this->compteur_h_sortie,
            'compteur_km_sortie' => $this->compteur_km_sortie,
            'compteur_h_retour' => $this->compteur_h_retour,
            'compteur_km_retour' => $this->compteur_km_retour,
            'observation_retour' => $this->observation_retour,
            'carburant_rempli_l' => $this->carburant_rempli_l,
            'engin' => new EnginResource($this->whenLoaded('engin')),
            'operateur' => new UserResource($this->whenLoaded('operateur')),
        ];
    }
}
