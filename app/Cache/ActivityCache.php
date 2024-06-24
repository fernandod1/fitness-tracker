<?php

namespace App\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use App\Services\ActivityService;

class ActivityCache {

    public function __construct(
        private ActivityService $activityService
    ) {}

    /**
     * updateCache function
     * 
     * Updates cache content of activities to display in index page to not identified users
     *
     * @return void
     */
    public function updateCache()
    {
        $page = Request::input('cursor','0');
        Cache::put('cachedActivities_'.$page, $this->activityService->getActivities());
    }

    /**
     * getCache function
     * 
     * Get cached activities to display in index page to not identified users     *
     *
     * @return mixed
     */
    public function getCache() {
        $page = Request::input('cursor','0');
        return Cache::rememberForever('cachedActivities_'.$page, function() {
            return $this->activityService->getActivities();
        });
    }    

}