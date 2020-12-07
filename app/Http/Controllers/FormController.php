<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Alcohol;
use App\Workout;
use App\Item;
use App\Snack;
use App\Sleep;
use App\Mood;
use App\User;
use App\Weight;
use App\Target;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeAcitivy(Request $request)
    {
        Validator::make($request->all(), [
            'time_hr' => 'required_without:time_min',
            'time_min' => 'required_without:time_hr',
            'date' => 'required'
        ])->validate();

        /*if ($validator->fails()) {
            return redirect('/activity')
                        ->withErrors($validator)
                        ->withInput();
        }*/

        $workout = new Workout();
        $workout->distance = $request->get('distance');
        $workout->date = $request->get('date');
        $workout->activity_id = $request->get('activity');

        $time_hr = $request->get('time_hr') * 60;
        $time_min = $request->get('time_min');
        $workout->time = $time_hr + $time_min;

        $workout->save();
        return redirect('/activity')->with('success', 'Activity has been added');
    }

    public function storeAlcohol(Request $request)
    {
        Validator::make($request->all(), [
            'calorie' => 'required',
            'drink_number' => 'required',
            'date' => 'required',
            'item_name' => 'required'
        ])->validate();

        $alcohol = new Alcohol();
        $alcohol->standard_drink = $request->get('drink_number');
        //kJ = calories * 4.184;

        if ($request->get('calorie_type') == "kj") {
            $calories = $request->get('calorie') / 4.184;
            $kj = $request->get('calorie');
        } else {
            $kj = $request->get('calorie') * 4.184;
            $calories = $request->get('calorie');
        }
        $alcohol->calories = $calories;
        $alcohol->kj = $kj;
        $alcohol->date = $request->get('date');
        $alcohol->item_id = $request->get('item_name');
        $alcohol->save();
        return redirect('/alcohol')->with('success', 'Alcohol details has been added');
    }

    public function storeSnack(Request $request)
    {
        $snack = new Snack();
        //kJ = calories * 4.184;
        if ($request->get('calorie_type') == "kj") {
            $calories = $request->get('calorie') / 4.184;
            $kj = $request->get('calorie');
        } else {
            $kj = $request->get('calorie') * 4.184;
            $calories = $request->get('calorie');
        }

        $snack->calories = $calories;
        $snack->kj = $kj;
        $snack->date = $request->get('date');
        $snack->item_id = $request->get('item_name');
        $snack->save();
        return redirect('/snack')->with('success', 'Snack details has been added');
    }

    public function storeSleep(Request $request)
    {
        $sleep = new Sleep();
        $sleep->date = $request->get('date');
        $sleep->time = $request->get('sleep_hours');
        $sleep->user_id = Auth::user()->id;
        $sleep->save();
        return redirect('/sleep')->with('success', 'Activity has been added');
    }

    public function storeMood(Request $request)
    {
        $mood = new Mood();
        $mood->date = $request->get('date');
        $mood->mood = $request->get('mood');
        $mood->user_id = Auth::user()->id;
        $mood->save();
        return redirect('/mood')->with('success', 'Activity has been added');
    }

    public function storeWeight(Request $request)
    {
        $weight = new Weight();
        $weight->date = $request->get('date');
        $weight->weight = $request->get('weight');
        $weight->user_id = Auth::user()->id;
        $weight->save();
        return redirect('/weight')->with('success', 'Activity has been added');
    }

    public function addActivity(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'activityName' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:25'
        ]);

        $activity = new Activity();
        $activity->name = $request->get('activityName');
        $activity->color = $request->get('activityColor');
        $activity->user_id = Auth::user()->id;
        $activity->save();
        return redirect('activity');
    }

    public function updateActivity(Request $request)
    {
        $activity = Activity::find($request->get('activity_id'));
        $activity->name = $request->get('activity_name');
        $activity->color = $request->get('activity_color');
        $activity->user_id = Auth::user()->id;
        $activity->save();
        return redirect('activity');
    }

    public function deleteActivity(Request $request)
    {
        $activity = Activity::find($request->get('activity_id'));
        $activity->user_id = Auth::user()->id;
        $activity->delete();
        return redirect('activity');
    }

    public function deleteTarget(Request $request)
    {
        $target = Target::find($request->get('target_id'));
        $target->user_id = Auth::user()->id;
        $target->delete();
        return redirect('home');
    }

    public function checkActivities(Request $request)
    {
        $workoutData = Workout::where('activity_id', '=', (int) $request->get('id'))->get();
        if (sizeof($workoutData) > 0) {
            return response()->json([
                'result' => 'Found'
            ]);
        } else {
            return response()->json([
                'result' => 'NotFound'
            ]);
        }
    }

    public function updateItem(Request $request)
    {
        $item = Item::find($request->get('item_id'));
        $item->name = $request->get('item_name');
        $item->user_id = Auth::user()->id;
        if ($request->get('item') == "alcohol") {
            $item->category = "alcohol";
        } else {
            $item->category = "snack";
        }

        $item->save();

        if ($request->get('item') == "alcohol") {
            return redirect('alcohol');
        } else {
            return redirect('snack');
        }
    }

    public function deleteItem(Request $request)
    {
        $item = Item::find($request->get('item_id'));
        $item->user_id = Auth::user()->id;
        if ($request->get('item') == "alcohol") {
            $item->category = "alcohol";
        } else {
            $item->category = "snack";
        }

        $item->delete();

        if ($request->get('item') == "alcohol") {
            return redirect('alcohol');
        } else {
            return redirect('snack');
        }
    }

    public function checkItems(Request $request)
    {
        $alcoholData = Alcohol::where('item_id', '=', (int) $request->get('id'))->get();
        $snackData = Snack::where('item_id', '=', (int) $request->get('id'))->get();


        if ($request->get('item') == "alcohol") {
            if (sizeof($alcoholData) > 0) {
                return response()->json([
                    'result' => 'Found'
                ]);
            } else {
                return response()->json([
                    'result' => 'NotFound'
                ]);
            }
        } else {
            if (sizeof($snackData) > 0) {
                return response()->json([
                    'result' => 'Found'
                ]);
            } else {
                return response()->json([
                    'result' => 'NotFound'
                ]);
            }
        }
    }

    public function getColor(Request $request)
    {
        $activity = Activity::find($request->get('activityId'));
        $activity->name = $request->get('activityName');
        $activity->color = $request->get('activityColor');
        $activity->user_id = Auth::user()->id;
        $activity->save();
        return redirect('activity');
    }

    public function addItem(Request $request)
    {
        $item = new Item();
        $item->name = $request->get('add_item_name');
        if ($request->get('item') == "alcohol") {
            $item->category = "alcohol";
        } else {
            $item->category = "snack";
        }

        $item->user_id = Auth::user()->id;
        $item->save();
        if ($request->get('item') == "alcohol") {
            return redirect('alcohol');
        } else {
            return redirect('snack');
        }
    }

    public function addTarget(Request $request)
    {
        // dd($request->get('add_target_name'));
        $target = new Target();
        $target->description = $request->get('add_target_name');
        $target->user_id = Auth::user()->id;
        $target->save();
        return redirect('home');
    }

    public function activityEntry()
    {
        $activities = Activity::where('user_id', auth()->id())->get()->sortBy('name');
        $workouts = DB::table('workouts')->join('activities','workouts.activity_id', '=', 'activities.id')->join('users', 'activities.user_id', '=', 'users.id')->where('users.id', auth()->id())->orderBy('date', 'desc')->get();
        $totalWorkoutDistance = DB::table('workouts')->join('activities','workouts.activity_id', '=', 'activities.id')->join('users', 'activities.user_id', '=', 'users.id')->where('users.id', auth()->id())->sum('distance');

        $totalTimeInMin = DB::table('workouts')->join('activities','workouts.activity_id', '=', 'activities.id')->join('users', 'activities.user_id', '=', 'users.id')->where('users.id', auth()->id())->sum('time');
        $totalTimeInHr = $totalTimeInMin / 60;
        return view('activity', compact('activities', 'workouts', 'totalTimeInMin', 'totalWorkoutDistance'));
    }

    public function alcoholEntry()
    {
        $items = Item::where('category', 'alcohol')->where('user_id', auth()->id())->get()->sortBy('name');
        $totalCalories = DB::table('alcohols')->join('items','alcohols.item_id', '=', 'items.id')->join('users', 'items.user_id', '=', 'users.id')->where('users.id', auth()->id())->sum('calories');
        $totalKj = DB::table('alcohols')->join('items','alcohols.item_id', '=', 'items.id')->join('users', 'items.user_id', '=', 'users.id')->where('users.id', auth()->id())->sum('kj');
        return view('alcohol', compact('items', 'totalCalories', 'totalKj'));
    }

    public function snackEntry()
    {
        $items = Item::where('category', 'snack')->where('user_id', auth()->id())->get()->sortBy('name');
        $totalCalories = DB::table('snacks')->join('items','snacks.item_id', '=', 'items.id')->join('users', 'items.user_id', '=', 'users.id')->where('users.id', auth()->id())->sum('calories');
        $totalKj = DB::table('snacks')->join('items','snacks.item_id', '=', 'items.id')->join('users', 'items.user_id', '=', 'users.id')->where('users.id', auth()->id())->sum('kj');
        return view('snack', compact('items', 'totalCalories', 'totalKj'));
    }

    public function itemEntry()
    {
        $items = Item::all()->sortBy('name');
        return view('alcohol', compact('items'));
    }

    public function sleepEntry()
    {
        $sleeps = Sleep::where('user_id', auth()->id())->get()->sortBy('date');
        $avgSleepHours = Sleep::where('user_id', auth()->id())->avg('time');
        return view('sleep', compact('sleeps', 'avgSleepHours'));
    }

    public function moodEntry()
    {
        $moods = Mood::where('user_id', auth()->id())->get()->sortBy('date');
        return view('mood', compact('moods'));
    }

    public function weightEntry()
    {
        $weights = Weight::where('user_id', auth()->id())->get()->sortBy('date');
        return view('weight', compact('weights'));
    }

    public function calendar()
    {
        $events = [];

        $workouts = DB::table('users')->join('activities', 'users.id', '=', 'activities.user_id')->join('workouts', 'activities.id', '=', 'workouts.activity_id')->selectRaw('workouts.time as time, activities.name, workouts.date,activities.color')->where('user_id', auth()->id())->get();

        if ($workouts->count()) {
            foreach ($workouts as $workout) {
                $events[] = Calendar::event(
                    $workout->name . " " . $workout->time . " " . "mins",
                    true,
                    new \DateTime($workout->date),
                    null,
                    null,
                    //add color
                    [
                        'color' => $workout->color,
                        'textColor' => 'white'
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        return view('calendar', compact('calendar'));
    }

    public function statistics()
    {
        $longestWorkout = Workout::max('time');
        dd($longestWorkout);
    }
}
