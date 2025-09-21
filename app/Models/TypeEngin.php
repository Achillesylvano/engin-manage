<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEngin extends Model
{
    use HasFactory;

    public function engins()
    {
        return $this->hasMany(Engin::class);
    }
}
