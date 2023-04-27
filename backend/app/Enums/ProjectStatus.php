<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ProjectStatus extends Enum
{
    const published = "published";
    const draft = "draft";
    const archived = "archived";
    const blocked = "blocked";
}
