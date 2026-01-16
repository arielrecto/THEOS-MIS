<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionFee extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'type',
        'amount',
        'is_active',
        'is_monthly',
        'is_onetime_fee',
        'tuition_fee_bracket_id',
        'payment_agreement',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_monthly' => 'boolean',
        'is_onetime_fee' => 'boolean',
        'amount' => 'decimal:2',
    ];


    public function bracket()
    {
        return $this->belongsTo(TuitionFeeBracket::class, 'tuition_fee_bracket_id');
    }

    public function strands()
    {
        return $this->belongsToMany(Strand::class, 'strand_tuition_fees');
    }
}
