<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'reporter_id', 'reportable_type', 'reportable_id',
        'reason', 'description', 'status',
        'resolved_by', 'resolved_at', 'admin_notes',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    // relasi ke user yang membuat laporan
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // relasi ke admin yang menyelesaikan laporan
    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    // relasi polimorfik ke objek yang dilaporkan (Event atau User)
    public function reportable()
    {
        return $this->morphTo();
    }
}