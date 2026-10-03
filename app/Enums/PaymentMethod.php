<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Mada = 'mada';
    case CreditCard = 'card';
    case BankTransfer = 'bank_transfer';
    case ApplePay = 'apple_pay';

    public function label(): string
    {
        return match ($this) {
            self::Mada => 'مدى',
            self::CreditCard => 'بطاقة ائتمانية',
            self::BankTransfer => 'تحويل بنكي',
            self::ApplePay => 'Apple Pay',
        };
    }
}
