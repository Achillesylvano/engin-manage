<?php

namespace App\Models;

use App\Builders\MaintenanceBuilder;
use App\Enums\MaintenanceStatus;
use App\Enums\MaintenanceType;
use App\Observers\MaintenanceObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $type
 * @property string|null $description
 * @property string|null $date_planifiee
 * @property string $statut
 * @property int $engin_id
 * @property int|null $technicien_id
 * @property int|null $responsable_id
 * @property int|null $incident_id
 * @property int|null $alert_maintenance_id
 * @property int|null $maintenance_automatique_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Engin $engin
 * @property-read \App\Models\User|null $technicien
 * @property-read \App\Models\User|null $responsable
 * @property-read \App\Models\Incident|null $incident
 * @property-read \App\Models\AlertMaintenance|null $alertMaintenance
 * @property-read \App\Models\MaintenanceAutomatique|null $maintenanceAutomatique
 */
#[ObservedBy([MaintenanceObserver::class])]
class Maintenance extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceFactory> */
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): MaintenanceBuilder
    {
        return new MaintenanceBuilder($query);
    }

    public function engin(): BelongsTo
    {
        return $this->belongsTo(Engin::class);
    }

    public function technicien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    public function alertMaintenance(): BelongsTo
    {
        return $this->belongsTo(AlertMaintenance::class);
    }

    public function intervention(): HasOne
    {
        return $this->hasOne(Intervention::class);
    }

    public function maintenanceAutomatique(): BelongsTo
    {
        return $this->belongsTo(MaintenanceAutomatique::class);
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function enRetard(Builder $query)
    {
        return $query->where('statut', MaintenanceStatus::PLANIFIEE)
            ->whereDate('date_planifiee', '<', now());
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function enCours(Builder $query)
    {
        return $query->where('statut', MaintenanceStatus::EN_COURS)
            ->whereDate('date_planifiee', now());
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function aVenir(Builder $query)
    {
        return $query->where('statut', MaintenanceStatus::PLANIFIEE)
            ->whereDate('date_planifiee', '>', now());
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function terminee(Builder $query)
    {
        return $query->where('statut', MaintenanceStatus::TERMINEE);
    }

    protected function casts(): array
    {
        return [
            'date_planifiee' => 'date',
            'date_debut' => 'datetime',
            'date_fin' => 'datetime',
            'statut' => MaintenanceStatus::class,
            'type' => MaintenanceType::class,
        ];
    }
}
