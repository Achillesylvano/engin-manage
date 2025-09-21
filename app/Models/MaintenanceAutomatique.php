<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceAutomatique extends Model
{
    protected $fillable = ['engin_id', 'type', 'description', 'dernier_compteur', 'seuil'];

    public function engin()
    {
        return $this->belongsTo(Engin::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}
