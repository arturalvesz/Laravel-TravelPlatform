<?php

namespace App\Http\Controllers\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserTimestamp;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Day;
use App\Models\Experience;
use App\Models\User;

class DayController extends Controller
{

    public function index(Experience $experience)
    {
        $days = Day::where('experience_id', $experience->id)->orderBy('id', 'asc')->paginate(10);


        return view('days.index', compact('days','experience'));
    }


    public function edit(Experience $experience, Day $day)
    {
       return view('days.edit', compact('experience','day'));
    }


    public function update(Request $request, Experience $experience, Day $day)
    {
    $request->validate([
        'date' => 'required|date_format:Y-m-d',
        'timeframe' => 'required|date_format:H:i:s',
        'max_people' => 'required|integer',
    ]);

    $day->experience_id = $experience->id;

    $day->date = $request->input('date');
    $day->timeframe = $request->input('timeframe');
    $day->max_people = $request->input('max_people');

    $day->save();

    return redirect('/days' . $day->experience_id)->with('success', 'Day updated successfully!');
}

    public function destroy(Day $day)
    {
        $day->delete();
        return redirect()->back()->with('success', 'Day deleted successfully!');
    }
}
