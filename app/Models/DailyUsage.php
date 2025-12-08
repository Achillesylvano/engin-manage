<?php

namespace App\Models;

use App\Builders\DailyUsageBuilder;
use App\Observers\DailyUsageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function engin(): BelongsTo
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

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function sortieDuJour(Builder $query)
    {
        return $query->whereDate('heure_sortie', now());
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function retourDuJour(Builder $query)
    {
        return $query->whereDate('heure_retour', now());
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function enCours(Builder $query)
    {
        return $query->where('is_returned', false);
    }

    public function broadcastOn(string $event): array
    {
        return [$this];
    }
}
