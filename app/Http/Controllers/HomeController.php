<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Mood;
use App\Sleep;
use App\Snack;
use App\Target;
use App\Weight;
use App\Workout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $targetData = Target::where('user_id', auth()->id())->get();
        $workoutData = DB::table('users')->join('activities', 'users.id', '=', 'activities.user_id')->join('workouts', 'activities.id', '=', 'workouts.activity_id')->selectRaw('sum(workouts.time) as number, activities.name')->groupBy('activities.name')->where('user_id', auth()->id())->get();

        $arrayPieChart[] = ['name', 'number'];
        if (sizeof($workoutData) > 0) {
            foreach ($workoutData as $key => $value) {
                $arrayPieChart[++$key] = [$value->name, (int) $value->number];
            }
        } else {
            //$arrayPieChart[1] = ['No activity', 0];
        }
        
        $snackData = DB::table('users')->join('items', 'users.id', '=', 'items.user_id')->join('snacks', 'items.id', '=', 'snacks.item_id')->selectRaw('sum(snacks.calories) as calories, snacks.date')->groupBy('snacks.date')->where('user_id', auth()->id())->get()->toArray();

        $arrayBarChart[] = ['date', 'calories'];
        $today = $dt = Carbon::now();
        if ($snackData != null) {
            foreach ($snackData as $key => $value) {
                $arrayBarChart[++$key] = [$value->date, (float) $value->calories];
            }
        } else {
            $arrayBarChart[1] = [$today->toDateString(), 0];
        }

        $avgSleepHrs = Sleep::where('user_id', auth()->id())->avg('time');
        $arraySleepGauge[] = ['date', 'time'];
        if ($avgSleepHrs != null) {
            $arraySleepGauge[1] = ["Sleep", $avgSleepHrs];
        } else {
            $arraySleepGauge[1] = ["Sleep", 0];
        }

        $moodData = Mood::selectRaw('mood, date')->where('user_id', auth()->id())->orderBy('date')->get()->last();
        $arrayGaugeChart[] = ['date', 'mood'];
        if ($moodData != null) {
            $arrayGaugeChart[1] = ["Mood", $moodData->mood];
        } else {
            $arrayGaugeChart[1] = ["Mood", 0];
        }

        $weightData = Weight::selectRaw('weight, date')->where('user_id', auth()->id())->get();
        $arrayLineChart[] = ['date', 'weight'];

        if (sizeof($weightData) > 0) {
            foreach ($weightData as $key => $value) {
                $arrayLineChart[++$key] = [$value->date, (float) $value->weight];
            }
        } else {
            $arrayLineChart[1] = [$today->toDateString(), 0];
        }

        $longestWorkout = DB::table('users')->join('activities', 'users.id', '=', 'activities.user_id')->join('workouts', 'activities.id', '=', 'workouts.activity_id')->selectRaw('max(workouts.time) as time,activities.name')->groupBy('activities.name')->where('user_id', auth()->id())->orderBy('time', 'desc')->get()->first();
        if ($longestWorkout != null) {
            $longestWorkoutTime = $longestWorkout->time;
            $longestWorkoutName = $longestWorkout->name;
        } else {
            $longestWorkoutTime = 0;
            $longestWorkoutName = "";
        }

        $furthestDistance = DB::table('users')->join('activities', 'users.id', '=', 'activities.user_id')->join('workouts', 'activities.id', '=', 'workouts.activity_id')->selectRaw('max(workouts.distance) as distance,activities.name')->groupBy('activities.name')->where('user_id', auth()->id())->orderBy('time', 'desc')->get()->first();

        if ($furthestDistance != null) {
            $furthestDistanceKm = $furthestDistance->distance;
            $furthestDistanceName = $furthestDistance->name;
        } else {
            $furthestDistanceKm = 0;
            $furthestDistanceName = "";
        }

        $userWorkoutTime = DB::table('users')->join('activities', 'users.id', '=', 'activities.user_id')->join('workouts', 'activities.id', '=', 'workouts.activity_id')->selectRaw('sum(time) as time, date')->groupBy('date')->where('user_id', auth()->id())->get();

        $maxMinWorkoutTime = DB::table('users')->join('activities', 'users.id', '=', 'activities.user_id')->join('workouts', 'activities.id', '=', 'workouts.activity_id')->selectRaw('max(time) as max, min(time) as min, date')->groupBy('date')->where('user_id', '!=', auth()->id())->get();

        return view('home', compact('targetData', 'longestWorkoutTime', 'longestWorkoutName', 'furthestDistanceKm', 'furthestDistanceName', 'userWorkoutTime', 'maxMinWorkoutTime'))->with('name', json_encode($arrayPieChart))->with('date', json_encode($arrayBarChart))->with('sleep', json_encode($arraySleepGauge))->with('mood', json_encode($arrayGaugeChart))->with('weight', json_encode($arrayLineChart));
    }
}
