<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedEvent extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'event_id', 'saved_at'];

    protected $casts = [
        'saved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (SavedEvent $model) {
            if (empty($model->saved_at)) {
                $model->saved_at = now();
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