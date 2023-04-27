<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AddressType extends Enum
{
    const Billing = "Billing";
    const Delivery = "Delivery";
}
