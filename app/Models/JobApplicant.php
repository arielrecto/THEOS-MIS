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
    ];


    public function position()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }


    public function resume(){
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
