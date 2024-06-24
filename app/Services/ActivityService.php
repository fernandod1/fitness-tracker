<?php

namespace App\Services;

use App\Models\Activity;
use App\Events\ActivityBroadcasting;

class ActivityService {
    const MILE_TO_METER = 1609.34;
    
    /**
     * getActivities method
     * 
     * Get all fitness activities
     *
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function getActivities() {
        $activities = Activity::with(['activity_type:id,name', 'user:id,name'])
                                ->orderBy('activity_date', 'desc');
        if(auth()->check())
            $activities->where("user_id", auth()->user()->id);
        return $activities->cursorPaginate(10);
    }

    /**
     * getActivitiesByType method
     * 
     * Get all fitness activities by type
     *
     * @param integer $typeId
     * @return \Illuminate\Contracts\Pagination\CursorPaginator
     */
    public function getActivitiesByType($typeId){
        $activities = Activity::with('activity_type')
                                ->where("activity_type_id", $typeId)
                                ->orderBy('activity_date', 'desc');
        if(auth()->check())
            $activities->where("user_id", auth()->user()->id);
        return $activities->cursorPaginate(10);
    }

    /**
     * CalculateActivityTotalGoals method
     * 
     * calculates and returns array key value with total distances and elapsed time about one activity type.
     *
     * @param integer $activityTypeId
     * @return array
     */    
    public function CalculateActivityTotalGoals(?int $typeId = null)
    {
        $activity = Activity::where("activity_type_id", $typeId);
        $activity = Request()->is('api/*') ? $activity : $activity->where("user_id", auth()->user()->id);
        $activityCollection = $activity->get(['distance', 'distance_unit', 'elapsed_time']);

        $totalGoals = $activityCollection->reduce(function ($carry, $item) {
            if ($item['distance_unit'] === 'miles') $item['distance'] *= self::MILE_TO_METER;
            if ($item['distance_unit'] === 'kilometers') $item['distance'] *= 1000;
            $carry["distanceMeters"] = isset($carry["distanceMeters"]) ? 
                                        $carry["distanceMeters"] + $item['distance'] : $item['distance'];
            $carry["elapsedTimeSeconds"] = isset($carry["elapsedTimeSeconds"]) ? 
                                        $carry["elapsedTimeSeconds"] + $item['elapsed_time'] : $item['elapsed_time'];
            return $carry;
        });
        return $totalGoals;
    }

    /**
     * StoreActivity method
     *
     * Store new activity in database
     * 
     * @param array $requestValidated
     * @return \App\Models\Activity
     */
    public function StoreActivity($requestValidated)
    {        
        $activity = Activity::create($requestValidated);
        $this->BroadcastNewActivity($activity);
        return $activity;
    }

    /**
     * BroadcastNewActivity method
     * 
     * Broadcast new activity via pusher to rest of active users in website
     *
     * @param Activity $activity
     * @return void
     */
    private function BroadcastNewActivity(Activity $activity)
    {
        $data = [
            "username" => $activity->user->name,
            "activity_type" => $activity->activity_type->name
        ];
        ActivityBroadcasting::dispatch($data);
    }

}