<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Role extends Enum
{
    const Regular = "Regular";
    const Pro = "Pro";
    const Moderator = "Moderator";
    const Administrator = "Administrator";
}
