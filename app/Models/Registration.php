<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ChatRoom;

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

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function chatRoom()
    {
        return $this->hasOne(ChatRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}