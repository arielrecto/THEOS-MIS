<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;


    protected $fillable = [
        'employee_profile_id',
        'leave_type',
        'start_date',
        'end_date',
        'days',
        'status',
        'reason',
        'approved_by',
    ];


    public function employee()
    {
        return $this->belongsTo(EmployeeProfile::class, 'employee_profile_id');
    }
}
