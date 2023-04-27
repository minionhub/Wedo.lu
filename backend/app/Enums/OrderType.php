<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderType extends Enum
{
    const Subscription = "Subscription";
    const Permanent = "Permanent";
}
