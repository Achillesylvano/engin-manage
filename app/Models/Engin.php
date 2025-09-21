<?php

namespace App\Models;

use App\Enums\EnginCarburant;
use App\Enums\EnginStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Engin extends Model
{
    /** @use HasFactory<\Database\Factories\EnginFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'date_aquisition' => 'date',
            'etat' => EnginStatus::class,
            'type_carburant' => EnginCarburant::class,
        ];
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function dailyUsages(): HasMany
    {
        return $this->hasMany(DailyUsage::class);
    }

    public function typeEngin(): BelongsTo
    {
        return $this->belongsTo(TypeEngin::class, 'type_engin_id', 'id');
    }

    public function scopeOperationnel(Builder $query): Builder
    {
        return $query->where('etat', EnginStatus::OPERATIONNEL);
    }

    public function scopeEnMaintenance(Builder $query): Builder
    {
        return $query->where('etat', EnginStatus::EN_MAINTENANCE);
    }

    public function scopeHorsService(Builder $query): Builder
    {
        return $query->where('etat', EnginStatus::HORS_SERVICE);
    }

    public function latestDailyUsage()
    {
        return $this->hasOne(DailyUsage::class)->latestOfMany();
    }

    public function scopeDisponibles(Builder $query): Builder
    {
        return $query->whereDoesntHave('dailyUsages')
            ->orWhereHas('latestDailyUsage', function ($q) {
                $q->where('is_returned', true);
            });
    }

    public function scopeSortie(Builder $query): Builder
    {
        return $query->whereHas('latestDailyUsage', function ($q) {
            $q->where('is_returned', false);
        });
    }

    public function maintenancesAutomatiques()
    {
        return $this->hasMany(MaintenanceAutomatique::class);
    }

    public function alertMaintenances()
    {
        return $this->hasMany(AlertMaintenance::class);
    }
}
