<?php

namespace App\Enums\Location;

use BenSampo\Enum\Enum;

final class LocationTypes extends Enum
{
    public const GENERAL =   'general';
    public const HOME =  'home';
    public const WORK = 'work';
    public const SHIP = 'ship';
}
