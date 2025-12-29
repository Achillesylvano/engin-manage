<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
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
            'date_signalement' => $this->date_signalement->format('d/m/Y H:i'),
            'description' => $this->description,
            'niveau_gravite' => $this->niveau_gravite,
            'resolu' => (bool) $this->resolu,
            'date_resolution' => optional($this->date_resolution)?->format('d/m/Y'),

            // Relations
            'engin' => EnginResource::make($this->whenLoaded('engin')),
            'technicien' => UserResource::make($this->whenLoaded('technicien')),

            'operateur' => UserResource::make($this->whenLoaded('operateur')),
            'daily_usage' => DailyUsageResource::make($this->whenLoaded('dailyUsage')),

            // Foreign keys
            'engin_id' => $this->engin_id,
            'operateur_id' => $this->operateur_id,
            'daily_usage_id' => $this->daily_usage_id,
        ];
    }
}
