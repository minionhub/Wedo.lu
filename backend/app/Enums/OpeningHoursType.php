<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OpeningHoursType extends Enum
{
    const custom = "custom";
    const openAllDay = "open all day";
    const closedAllDay = "closed all day";
    const byAppointment = "by appointment";
}
