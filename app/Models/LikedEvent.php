<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LikedEvent extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'event_id', 'liked_at'];

    protected $casts = [
        'liked_at' => 'datetime',
    ];
    protected static function booted(): void
    {
        static::creating(function (LikedEvent $model) {
            if (empty($model->liked_at)) {
                $model->liked_at = now();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}