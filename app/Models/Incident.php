<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Incident extends Model
{
    /** @use HasFactory<\Database\Factories\IncidentFactory> */
    use HasFactory;

    public function engin(): BelongsTo
    {
        return $this->belongsTo(Engin::class);
    }

    public function operateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operateur_id');
    }

    public function maintenance(): HasOne
    {
        return $this->hasOne(Maintenance::class);
    }

    protected function casts(): array
    {
        return [
            'date_signalement' => 'date',
        ];
    }
}
