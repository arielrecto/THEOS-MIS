<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreValueItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'core_value_id',
        'item_name',
        'item_description',
        'is_active',
    ];



    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function coreValue()
    {
        return $this->belongsTo(CoreValue::class);
    }
}
