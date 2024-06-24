<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Activity class
 * 
 * Model of Activity class
 * 
 */
class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'activity_type_id', 'activity_date', 'name', 'distance', 'distance_unit', 'elapsed_time'];

    public $timestamps = false;

    /**
     * activity_type method
     * 
     * relations between models/tables
     *
     * @return BelongsTo
     */
    public function activity_type(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class);
    }

    /**
     * user method
     * 
     * relations between models/tables
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * getActivityDateAttribute method
     * 
     * Formats datetime from database
     *
     * @param mixed $value
     * @return string|false
     */
    public function getActivityDateAttribute($value)
    {
        return date_format(new \DateTimeImmutable($value), 'd-m-Y H:i');
    }

    /**
     * getNameAttribute method
     * 
     * Formats name from database
     *
     * @param mixed $value
     * @return string|false
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
