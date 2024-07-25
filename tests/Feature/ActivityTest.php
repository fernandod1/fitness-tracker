<?php
 
namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
 
class ActivityTest extends TestCase
{      
    use RefreshDatabase;

	protected $user;
    protected $activityType;
    protected $activity;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); 
        $this->activityType = ActivityType::factory()->create();
        $this->activity = Activity::factory()->create();  
    }

    public function test_activity_model_exists_in_db(): void
    {
        $this->assertModelExists($this->activity);
    }
   
    public function test_activities_mainpage_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response
            ->assertStatus(200)
            ->assertSeeText('Last tracks of users', $response->getContent());
    }
    public function test_activities_filterpage_returns_a_successful_response_if_not_login(): void
    {
        $response = $this->get("/activity/filter?activity_type_id={$this->activityType->id}");
        $response
            ->assertStatus(302)
            ->assertRedirect('/login');
    }
    public function test_activities_filterpage_returns_a_successful_response_if_login(): void
    {
        $response = $this
            ->actingAs($this->user,'web')
            ->get("/activity/filter?activity_type_id={$this->activityType->id}");
        $response->assertStatus(200);
    }

    public function test_count_activities_database()
    {
        $this->assertDatabaseCount('activities', 1);
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
            'elapsed_time' => 15
        ];
        $response = $this
            ->actingAs($this->user, 'web')
            ->post('/activity/store',  $data);

        $activity = Activity::where('name', $randName)->first();
        $this->assertNotNull($activity);
        $response->assertFound()->assertStatus(302);
        $this->assertEquals(ucfirst($data['name']), $activity->name);
    }

 
    public function test_if_activities_view_loads_and_contains_text()
    {
        $this->actingAs($this->user, 'web');
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('Last tracks of users');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->user);
        unset($this->activityType);
        unset($this->activity);
    }
}

