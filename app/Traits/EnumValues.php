<?php
namespace App\Traits;
trait EnumValues
{
  /**
   * values function
   * 
   * Generates array values of enum
   *
   * @return array
   */
    public static function values(): array
    {
      return array_column(self::cases(), 'value');
    }
}