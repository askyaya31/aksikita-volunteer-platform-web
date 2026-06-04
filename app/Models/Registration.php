<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'event_id', 'user_id', 'status', 'registered_at',
        'cancelled_at', 'cancellation_reason', 'notes',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'cancelled_at'  => 'datetime',
    ];

    // relasi ke event yang didaftari
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // relasi ke volunteer yang mendaftar
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}