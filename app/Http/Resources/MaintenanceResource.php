<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type->label(),
            'description' => $this->description,
            'date_planifiee' => $this->date_planifiee->format('d-m-Y'),
            'statut' => $this->statut->label(),
            'engin' => EnginResource::make($this->whenLoaded('engin')),
            'engin_id' => $this->engin_id,
            'technicien' => UserResource::make($this->whenLoaded('technicien')),
            'technicien_id' => $this->technicien_id,
            'responsable' => UserResource::make($this->whenLoaded('responsable')),
            'responsable_id' => $this->responsable_id,
            'incident' => IncidentResource::make($this->whenLoaded('incident')),
            'incident_id' => $this->incident_id,
        ];
    }
}
