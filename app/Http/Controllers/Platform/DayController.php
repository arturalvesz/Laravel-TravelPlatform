<?php

namespace App\Http\Controllers\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserTimestamp;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Day;
class DayController extends Controller
{

    public function showTimeframes(Request $request)
    {
        $selectedDayId = $request->input('selectedDay');
        $selectedDay = Day::find($selectedDayId);

        // Retrieve the timeframes for the selected day
        $timeframes = $selectedDay->timeframes;

        // Pass the data to the Blade view
        return view('your.blade.view', [
            'selectedDay' => $selectedDay,
            'timeframes' => $timeframes,
        ]);
    }
}
