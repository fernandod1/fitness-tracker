<?php

namespace App\Cache;

use App\Models\Activity;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use App\Events\ActivityCreated;
use App\Events\ActivityBroadcasting;
use App\Services\ActivityTypeService;

class ActivityTypeCache {

    public function __construct(
        private ActivityTypeService $activityTypeService
    ) {}

    public function updateCache()
    {
        Cache::put('cachedActivityTypes', $this->activityTypeService->getActivityTypes());
    }

    public function getCache() {
        return Cache::rememberForever('cachedActivityTypes', function() {
            return $this->activityTypeService->getActivityTypes();
        });
    }
    

}