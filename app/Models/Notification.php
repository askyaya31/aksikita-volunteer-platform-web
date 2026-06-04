<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'title', 'message', 'type', 'related_event_id', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // relasi ke user penerima notifikasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke event yang terkait dengan notifikasi ini (opsional)
    public function relatedEvent()
    {
        return $this->belongsTo(Event::class, 'related_event_id');
    }
}