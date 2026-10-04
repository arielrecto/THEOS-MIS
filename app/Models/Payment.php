<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_account_id',
        'amount',
        'status',
        'payment_method',
        'attachment',
        'note',
    ];


    /**
     * Count and total amount per status for a user's payments, keyed by status value.
     * Statuses with no payments are still present with zero values.
     */
    public static function summaryFor(int $userId): array
    {
        $rows = static::where('user_id', $userId)
            ->selectRaw('status, COUNT(*) as count, COALESCE(SUM(amount), 0) as total')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return collect(PaymentStatus::cases())
            ->mapWithKeys(fn(PaymentStatus $status) => [$status->value => [
                'count' => (int) ($rows[$status->value]->count ?? 0),
                'total' => (float) ($rows[$status->value]->total ?? 0),
            ]])
            ->all();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentAccount()
    {
        return $this->belongsTo(PaymentAccount::class);
    }
}
