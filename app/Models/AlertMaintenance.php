<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertMaintenance extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $guarded = [];

    public function engin(): BelongsTo
    {
        return $this->belongsTo(Engin::class);
    }

    public function maintenanceAutomatique(): BelongsTo
    {
        return $this->belongsTo(MaintenanceAutomatique::class);
    }

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }
}
