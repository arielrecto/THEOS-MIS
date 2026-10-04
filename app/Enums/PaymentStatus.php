<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
