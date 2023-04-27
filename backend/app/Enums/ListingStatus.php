<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ListingStatus extends Enum
{
    const Draft = "draft";
    const Published = "published";
    const Blocked = "blocked";
}
