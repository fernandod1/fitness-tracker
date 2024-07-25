<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiActivityTest extends TestCase
{
    use RefreshDatabase;
	protected $user;
    protected $activityType;
    protected $activity;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->activityType = ActivityType::factory()->create();
        $this->activity = Activity::factory()->create();  
    }

    public function test_get_activities_data_in_valid_format() {
        $jsonStruct = [
            "activities" => [
                "data" => [
                    '*' => [
                        "id",
                        "activity_type_id",
                        "activity_date",
                        "name",
                        "distance",
                        "distance_unit",
                        "elapsed_time",
                        "activity_type" => [
                            "id", 
                            "name" 
                        ] 
                    ]
                ], 
                "path", 
                "per_page", 
                "next_cursor", 
                "next_page_url", 
                "prev_cursor", 
                "prev_page_url"
            ], 
            "success"
        ];
        $this->actingAs($this->user)            
            ->json('get', 'api/v1/activities')            
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure($jsonStruct)
            ->assertJsonFragment(["success" => true]);           
    }

    public function test_store_activity_in_database() {
        $jsonStruct = [
            "activities" => [
                  "user_id",
                  "activity_type_id", 
                  "activity_date", 
                  "name", 
                  "distance", 
                  "distance_unit", 
                  "elapsed_time", 
                  "id",
                  "user" => [
                    "id",
                    "name",
                    "email",
                    "email_verified_at",
                    "created_at",
                    "updated_at"
                  ],
                  "activity_type" => [
                    "id",
                    "name"
                  ]
               ],
            "success" 
        ]; 
        $payload = $this->activity;
        $payloadArr = $payload->toArray();
        $payloadArr['activity_date'] = date("Y-m-d H:i");

        $this->actingAs($this->user)
            ->json('post', 'api/v1/activities', $payloadArr)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure($jsonStruct);
        $this->assertDatabaseHas('activities', ["id" => $this->activity->id]);
    }

    public function test_get_activities_by_type_in_valid_format() {
        $jsonStruct = [
            "activities" => [
                "data" => [
                    '*' => [
                        "id",
                        "user_id",
                        "activity_type_id",
                        "activity_date",
                        "name",
                        "distance",
                        "distance_unit",
                        "elapsed_time",
                        "activity_type" => [
                            "id", 
                            "name" 
                        ] 
                    ]
                ], 
                "path", 
                "per_page", 
                "next_cursor", 
                "next_page_url", 
                "prev_cursor", 
                "prev_page_url"
            ],
            "total_goals" =>[
                "distanceMeters",
                "elapsedTimeSeconds"
            ],
            "success"
        ];

        $this->actingAs($this->user)
            ->json('get', 'api/v1/activities/types/'.$this->activityType->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure($jsonStruct)
            ->assertJsonFragment(["success" => true]);  
    }

    public function test_get_activities_by_type_returns_error_if_typeid_not_valid()
    {
        $invalidTypeId = 9876543210978676;
        $this->actingAs($this->user)
            ->json('get', 'api/v1/activities/types/'.$invalidTypeId)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment(["success" => false, "message" => "Activity type not valid"]);
    }

    public function test_dont_store_activity_in_database_if_some_field_is_missing() {
        $payloadArr = $this->activity->toArray();
        $payloadArr['activity_date'] = date("Y-m-d H:i");
        unset($payloadArr["name"]); // suposing name field missing

        $this->actingAs($this->user)
            ->json('post', 'api/v1/activities', $payloadArr)
            ->assertStatus(Response::HTTP_BAD_REQUEST);            
    }
}