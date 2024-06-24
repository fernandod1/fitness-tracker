<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * ActivityType class
 * 
 * Model of ActivityType class
 * 
 */
class ActivityType extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * activity method
     * 
     * relations between models/tables
     *
     * @return HasMany
     */
    public function activity(): HasMany
    {
        return $this->HasMany(Activity::class);
    }
}
