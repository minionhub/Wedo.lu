<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const Pending = "Pending";
    const Processing = "Processing";
    const Completed = "Completed";
    const Refunded = "Refunded";
    const Canceled = "Canceled";
    const Failed = "Failed";
}
