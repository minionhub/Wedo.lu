<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentMethod extends Enum
{
    const bankTransfer = "bankTransfer";
    const creditCard = "creditCard";
}
