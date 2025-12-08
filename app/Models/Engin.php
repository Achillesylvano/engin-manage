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

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function operationnel(Builder $query): Builder
    {
        return $query->where('etat', EnginStatus::OPERATIONNEL);
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function enMaintenance(Builder $query): Builder
    {
        return $query->where('etat', EnginStatus::EN_MAINTENANCE);
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function horsService(Builder $query): Builder
    {
        return $query->where('etat', EnginStatus::HORS_SERVICE);
    }

    public function latestDailyUsage()
    {
        return $this->hasOne(DailyUsage::class)->latestOfMany();
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function disponibles(Builder $query): Builder
    {
        return $query->whereDoesntHave('dailyUsages')
            ->orWhereHas('latestDailyUsage', function ($q): void {
                $q->where('is_returned', true);
            });
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function sortie(Builder $query): Builder
    {
        return $query->whereHas('latestDailyUsage', function ($q): void {
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
