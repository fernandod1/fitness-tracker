<?php
namespace App\Enums;
use App\Traits\{EnumOptions,EnumValues};

/**
 * DistanceUnit enum
 * 
 */
enum DistanceUnit: string 
{
    use EnumValues;
    use EnumOptions;
    case MILES        = 'miles';
    case KILOMETERS   = 'kilometers';
    case METERS       = 'meters';
}