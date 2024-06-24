<?php

namespace App\Observers;

use App\Models\ActivityType;
use App\Services\ActivityTypeService;
use App\Cache\ActivityTypeCache;

class ActivityTypeObserver
{
    public function __construct(private readonly ActivityTypeCache $activityTypeCache) {}
    /**
     * Handle the ActivityType "created" event.
     */
    public function created(ActivityType $activityType): void
    {
        $this->activityTypeCache->updateCache();
    }

    /**
     * Handle the ActivityType "updated" event.
     */
    public function updated(ActivityType $activityType): void
    {
        //
    }

    /**
     * Handle the ActivityType "deleted" event.
     */
    public function deleted(ActivityType $activityType): void
    {
        $this->activityTypeCache->updateCache();
    }

    /**
     * Handle the ActivityType "restored" event.
     */
    public function restored(ActivityType $activityType): void
    {
        //
    }

    /**
     * Handle the ActivityType "force deleted" event.
     */
    public function forceDeleted(ActivityType $activityType): void
    {
        //
    }
}
