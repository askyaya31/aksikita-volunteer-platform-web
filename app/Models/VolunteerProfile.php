<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerProfile extends Model
{
    protected $fillable = [
        'user_id', 'date_of_birth', 'gender', 'bio',
        'skills', 'interests', 'city', 'province', 'avatar', 'total_events_joined',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'skills'        => 'array', 
        'interests'     => 'array',
    ];

    // relasi ke akun user pemilik profil volunteer ini
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}