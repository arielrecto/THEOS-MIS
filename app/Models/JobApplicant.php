<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicant extends Model
{
    use HasFactory;


    protected $fillable = [
        'job_position_id',
        'name',
        'email',
        'phone',
        'linkedin',
        'portfolio',
        'cover_letter',
        'status',
        'hired_at',
    ];

    protected $casts = [
        'hired_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        // Record when an applicant is hired, wherever the status change comes from.
        static::saving(function (JobApplicant $applicant) {
            if ($applicant->isDirty('status')) {
                $applicant->hired_at = $applicant->status === 'hired'
                    ? ($applicant->hired_at ?? now())
                    : null;
            }
        });
    }


    public function position()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }


    public function resume(){
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
