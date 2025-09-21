<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'matricule',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class, 'operateur_id');
    }

    public function maintenancePlanifiees()
    {
        return $this->hasMany(Maintenance::class, 'responsable_id');
    }

    public function maintenancesEffectuees()
    {
        return $this->hasMany(Maintenance::class, 'technicien_id');
    }

    public function dailyUsages()
    {
        return $this->hasMany(DailyUsage::class, 'operateur_id');
    }

    public function scopeTechnicien(Builder $query)
    {
        return $query->where('role', UserRole::TECHNICIEN);
    }

    public function scopeResponsableFlotte(Builder $query)
    {
        return $query->where('role', UserRole::RESPONSABLE_FLOTTE);
    }

    public function scopeOperateur(Builder $query)
    {
        return $query->where('role', UserRole::OPERATEUR);
    }
}
