<?php

namespace App\Enums;

enum Couponable: string
{
    case Hotels = 'hotels';
    case Flights = 'flights';
    case Packages = 'packages';
}
