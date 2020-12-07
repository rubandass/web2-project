<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Workout;


class WorkoutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserTest()
    {
		$workout = Workout::find(1);
		$this->assertEquals(‘Dale’,$workout->user->name);
       
    }
}
