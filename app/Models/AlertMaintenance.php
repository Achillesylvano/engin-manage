<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertMaintenance extends Model
{
    protected $guarded = [];

    public function engin()
    {
        return $this->belongsTo(Engin::class);
    }

    public function maintenanceAutomatique()
    {
        return $this->belongsTo(MaintenanceAutomatique::class);
    }
}
