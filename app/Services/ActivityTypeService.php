<?php

namespace App\Services;

use App\Models\ActivityType;

class ActivityTypeService {

    /**
     * getActivityTypes method
     * 
     * Get all activity types
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivityTypes() {
        return ActivityType::orderBy('name', 'asc')->get();
    }
}