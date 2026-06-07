<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    'organization_profile_id', 'title', 'slug', 'description', 'poster',
    'location_name', 'location_address', 'city', 'province',
    'start_date', 'end_date', 'start_time', 'end_time',
    'quota', 'registered_count', 'likes_count',  
    'status', 'reviewed_by', 'reviewed_at', 'rejection_reason',
    'contact_person', 'contact_phone', 'requirements',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(OrganizationProfile::class, 'organization_profile_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'event_categories');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function isFull(): bool
    {
        return $this->registered_count >= $this->quota;
    }

    public function isOpen(): bool
    {
        return $this->status === 'published' && !$this->isFull();
    }

    public function remainingQuota(): int
    {
        return max(0, $this->quota - $this->registered_count);
    }
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . Str::random(6);
            }
        });
    }
}