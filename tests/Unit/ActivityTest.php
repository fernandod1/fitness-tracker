<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Activity;

class ActivityTest extends TestCase
{
    public function test_format_activity_date_without_seconds_attribute()
    {
        $dateTime = "2020-10-25 10:30:00";
        $activity = new Activity();
        $dateTimeNew = $activity->getActivityDateAttribute($dateTime);
        $this->assertEquals($dateTimeNew, "25-10-2020 10:30");
    }
}
