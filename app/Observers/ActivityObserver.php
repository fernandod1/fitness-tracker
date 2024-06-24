<?php

namespace App\Observers;

use App\Models\Activity;
use App\Cache\ActivityCache;

class ActivityObserver
{
    public function __construct(private readonly ActivityCache $activityCache) {}

    /**
     * Handle the Activity "created" event.
     */
    public function created(Activity $activity): void
    {
        $this->activityCache->updateCache();
    }

    /**
     * Handle the Activity "updated" event.
     */
    public function updated(Activity $activity): void
    {
        //
    }

    /**
     * Handle the Activity "deleted" event.
     */
    public function deleted(Activity $activity): void
    {
        $this->activityCache->updateCache();
    }

    /**
     * Handle the Activity "restored" event.
     */
    public function restored(Activity $activity): void
    {
        //
    }

    /**
     * Handle the Activity "force deleted" event.
     */
    public function forceDeleted(Activity $activity): void
    {
        //
    }
}
