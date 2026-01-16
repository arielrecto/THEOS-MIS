<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionFeeBracket extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];


    public function fees()
    {
        return $this->hasMany(TuitionFee::class, 'tuition_fee_bracket_id');
    }
}
