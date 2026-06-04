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
        'quota', 'registered_count', 'status',
        'reviewed_by', 'reviewed_at', 'rejection_reason',
        'requirements', 'contact_person', 'contact_phone',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'reviewed_at' => 'datetime',
    ];

    // relasi ke profil organisasi yang membuat event ini
    public function organization()
    {
        return $this->belongsTo(OrganizationProfile::class, 'organization_profile_id');
    }

    // relasi ke admin yang mereview event ini
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // relasi many-to-many ke categories lewat tabel pivot event_categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'event_categories');
    }

    // relasi ke semua pendaftaran untuk event ini
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // cek apakah kuota event sudah penuh
    public function isFull(): bool
    {
        return $this->registered_count >= $this->quota;
    }

    // cek apakah event masih bisa didaftari
    public function isOpen(): bool
    {
        return $this->status === 'published' && !$this->isFull();
    }

    // hitung sisa kuota yang tersedia
    public function remainingQuota(): int
    {
        return max(0, $this->quota - $this->registered_count);
    }

    // auto-generate slug dari title saat event baru dibuat
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