<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    use HasFactory;


    protected $fillable = [
        'account_name',
        'account_number',
        'provider',
        'qr_image_path'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
