<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\ApiStoreActivityRequest;
use App\Http\Requests\ApiFilterActivityRequest;
use App\Models\ActivityType;
use App\Services\ActivityService;
use App\Services\ActivityTypeService;
use Illuminate\Http\Request;

class ActivityController extends \App\Http\Controllers\Controller
{
    public function __construct(
        private ActivityService $activityService,
        private ActivityTypeService $activityTypeService
    ) {
    }
    const MILE_TO_METER = 1609.34;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $activities = $this->activityService->getActivities();
        return response()->json(['activities' => $activities, 'success' => true], 200);
    }

    /**
     * filterByActivityType method
     * 
     * filters activities listing by type
     *
     * @param ActivityType $activity_type
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterByActivityType(ApiFilterActivityRequest $request)
    {
        //dd($request);
        /*
        print_r($activity_type->id);
        if(!$activity_type->id->exists())
            dd($activity_type);
        */
        //if(!ActivityType::where("id", $activity_type)->exists())
        //    return response()->json(['activities' => '', 'total_goals' => '', 'success' => false], 400);
        $activities = $this->activityService->getActivitiesByType($request->activity_type);        
        $totalGoals = $this->activityService->CalculateActivityTotalGoals($request->activity_type);
        return response()->json(['activities' => $activities, 'total_goals' => $totalGoals, 'success' => true], 200);
    }

    /**
     * store method
     * 
     * Store new activity in database
     *
     * @param ApiStoreActivityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ApiStoreActivityRequest $request)
    {
        $activity = $this->activityService->StoreActivity($request->validated());
        return response()->json(['activities' => $activity, 'success' => true], 201);
    }

    /**
     * token method
     * 
     * Generate API token for registered user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function token(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Username or password invalid.'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'access_token' => $authToken
        ], 200);
    }
}
