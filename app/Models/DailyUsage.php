<?php

namespace App\Models;

use App\Builders\DailyUsageBuilder;
use App\Observers\DailyUsageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([DailyUsageObserver::class])]
class DailyUsage extends Model
{
    /** @use HasFactory<\Database\Factories\DailyUsageFactory> */
    use BroadcastsEvents,HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): DailyUsageBuilder
    {
        return new DailyUsageBuilder($query);
    }

    protected function casts(): array
    {
        return [
            'heure_sortie' => 'datetime',
            'heure_retour' => 'datetime',
            'date_usage' => 'date',
        ];
    }

    public function engin()
    {
        return $this->belongsTo(Engin::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function operateur()
    {
        return $this->belongsTo(User::class, 'operateur_id');
    }

    public function scopeSortieDuJour(Builder $query)
    {
        return $query->whereDate('heure_sortie', now());
    }

    public function scopeRetourDuJour(Builder $query)
    {
        return $query->whereDate('heure_retour', now());
    }

    public function scopeEnCours(Builder $query)
    {
        return $query->where('is_returned', false);
    }

    public function broadcastOn(string $event): array
    {
        return [$this];
    }
}
