<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    protected $fillable = [
        'user_id', 'organization_name', 'description', 'address',
        'city', 'province', 'website', 'logo', 'document_path',
        'verification_status', 'verified_at', 'verified_by', 'rejection_reason',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }
}