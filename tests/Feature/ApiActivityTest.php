<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Activity;
use App\Models\ActivityType;

class ApiActivityTest extends TestCase
{
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
       
        $this->json('get', 'api/v1/activities')
             ->assertStatus(Response::HTTP_OK)
             ->assertJsonStructure($jsonStruct)
             ->assertJsonFragment(["success" => true]);           
    }

    public function test_store_activity_in_database() {
        $jsonStruct = [
            "activities" => [
                  "activity_type_id", 
                  "activity_date", 
                  "name", 
                  "distance", 
                  "distance_unit", 
                  "elapsed_time", 
                  "id"
               ], 
            "success" 
        ]; 
        $payload = Activity::factory()->create();
        $payloadArr = $payload->toArray();
        $payloadArr['activity_date'] = date("Y-m-d H:i");
        $this->json('post', 'api/v1/activities', $payloadArr)
             ->assertStatus(Response::HTTP_CREATED)
             ->assertJsonStructure($jsonStruct);
        $this->assertDatabaseHas('activities', ["name" => $payloadArr['name']]);
    }

    public function test_get_activities_by_type_in_valid_format() {
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
            "total_goals" =>[
                "distanceMeters",
                "elapsedTimeSeconds"
            ],
            "success"
        ];

        $randId = ActivityType::all()->random()->id;
        $this->json('get', 'api/v1/activities/types/'.$randId)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure($jsonStruct)
        ->assertJsonFragment(["success" => true]);  
    }

    public function test_get_activities_by_type_returns_error_if_typeid_not_valid()
    {
        $this->json('get', 'api/v1/activities/types/9876543210')
        ->assertStatus(Response::HTTP_BAD_REQUEST)
        ->assertJsonFragment(["success" => false, "message" => "Fields validation errors"]);
    }

    public function test_dont_store_activity_in_database_if_some_field_is_missing() {
        // suposing name field is missing
        $payload = [
                  "activity_type_id" => ActivityType::all()->random()->id,
                  "activity_date" => "2000-12-10 12:10:00",
                  //"name", 
                  "distance" => 20, 
                  "distance_unit" => "kilometers", 
                  "elapsed_time" => 5000 
        ];

        $this->json('post', 'api/v1/activities', $payload)
             ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

}