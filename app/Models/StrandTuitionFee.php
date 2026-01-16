<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrandTuitionFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_fee_id',
        'strand_id',
    ];




    public function tuitionFee()
    {
        return $this->belongsTo(TuitionFee::class);
    }

    public function strand()
    {
        return $this->belongsTo(Strand::class);
    }
}
