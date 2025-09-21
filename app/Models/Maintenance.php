<?php

namespace App\Models;

use App\Builders\MaintenanceBuilder;
use App\Enums\MaintenanceStatus;
use App\Enums\MaintenanceType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Maintenance extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceFactory> */
    use HasFactory;

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

    public function intervention(): HasOne
    {
        return $this->hasOne(Intervention::class);
    }

    public function scopeEnRetard(Builder $query)
    {
        return $query->where('statut', MaintenanceStatus::PLANIFIEE)
            ->whereDate('date_planifiee', '<', now());
    }

    public function scopeEnCours(Builder $query)
    {
        return $query->where('statut', MaintenanceStatus::EN_COURS)
            ->whereDate('date_planifiee', now());
    }

    public function scopeAVenir(Builder $query)
    {
        return $query->where('statut', MaintenanceStatus::PLANIFIEE)
            ->whereDate('date_planifiee', '>', now());
    }

    public function scopeTerminee(Builder $query)
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
