<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\FilterActivityRequest;
use App\Cache\ActivityCache;
use App\Cache\ActivityTypeCache;
use App\Services\ActivityService;
use App\Services\ActivityTypeService;
use Illuminate\Support\Facades\Gate;

/**
 * ActivityController class
 * 
 * method related to fitness activities model
 * 
 */
class ActivityController extends Controller
{
    public function __construct(
        private ActivityService $activityService,
        private ActivityTypeService $activityTypeService,
        private ActivityCache $activityCache,
        private ActivityTypeCache $activityTypeCache
    ) {}

    /**
     * index method
     *
     * Listing of all cached activities for not identified users.
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     * 
     */
    public function index(Request $request)
    {        
        $activities = $this->activityCache->getCache();
        $activityTypes = $this->activityTypeCache->getCache();
        return view('activity.index', compact('activities', 'activityTypes'));
    }

    /**
     * dashboard method
     *
     * Listing of all activities and types of activities for identified users.
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     * 
     */
    public function dashboard(Request $request)
    {        
        $activities = $this->activityService->getActivities();
        $activityTypes = $this->activityTypeService->getActivityTypes();
        return view('activity.index', compact('activities', 'activityTypes'));
    }

    /**
     * filterByActivityType method
     * 
     * filters activities by activity_type_id param
     *
     * @param FilterActivityRequest $request
     * @return \Illuminate\Contracts\View\View
     */
    public function filterByActivityType(FilterActivityRequest $request)
    {
        $activities = $this->activityService->getActivitiesByType($request->activity_type_id);
        $activityTypes = $this->activityTypeService->getActivityTypes();
        $totalGoals = $this->activityService->CalculateActivityTotalGoals($request->activity_type_id);
        return view('activity.index', compact('activities', 'activityTypes', 'totalGoals'));
    }

    /**
     * store method
     * 
     * Saves in database a new fitness activity.
     *
     * @param StoreActivityRequest $request
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function store(StoreActivityRequest $request)
    {
        $this->activityService->StoreActivity($request->validated());       
        return redirect()->route('dashboard')->with('success', 'New fitness activity added.');
    }

    /**
     * destroy method
     * 
     * Remove the specified resource from storage.
     *
     * @param Activity $activity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Activity $activity)
    {
        Gate::authorize('delete', $activity);
        $activity->delete();
        return redirect()->route('dashboard')->with('success', 'Activity record deleted.');
    }
}
