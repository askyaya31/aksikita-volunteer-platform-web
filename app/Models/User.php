<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'avatar', 'is_active',
        'google_id', 
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
        'password'          => 'hashed',
    ];

    public function organizationProfile()
    {
        return $this->hasOne(OrganizationProfile::class);
    }

    public function volunteerProfile()
    {
        return $this->hasOne(VolunteerProfile::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOrganization(): bool
    {
        return $this->role === 'organization';
    }

    public function isVolunteer(): bool
    {
        return $this->role === 'volunteer';
    }

    public function isGoogleAccount(): bool
    {
        return !is_null($this->google_id);
    }
}
