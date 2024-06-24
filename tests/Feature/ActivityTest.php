<?php
 
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\User;
use Illuminate\Support\Str;
 
class ActivityTest extends TestCase
{  
    public function test_activity_model_exists_in_db(): void
    {
        $activity = Activity::factory()->create(); 
        $this->assertModelExists($activity);
    }

    public function test_activities_mainpage_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_activities_filterpage_returns_a_successful_response(): void
    {
        $response = $this->get('/filter');
        if(auth()->check())
            $response->assertStatus(302);
        else
            $response->assertStatus(404);
    }

    public function test_activities_database()
    {
        Activity::factory()->count(4)->create();
        $totalActivities = Activity::count(); 
        $this->assertDatabaseCount('activities', $totalActivities);
    }

    public function test_store_new_activity()
    {
        $randName = Str::random(15);
        $data = [
            'user_id' => User::all()->random()->id,
            'activity_type_id' => ActivityType::all()->random()->id,
            'activity_date' => '2000-10-10 12:30',
            'name' => $randName,
            'distance' => 76,
            'distance_unit' => 'meters',
            'elapsed_time' => 15,
        ];
        $response = $this->post('/store', $data);
        $activity = Activity::where('name', $randName)->first();
        $this->assertNotNull($activity);
        $response->assertFound()->assertStatus(302);
        $this->assertEquals($data['name'], $activity->name);
    }

    public function test_if_activities_view_loads_and_contains_text()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Fitness activities records');
    }

}