<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Day;
use Carbon\Carbon;
use App\Models\OrderExperience;
class ExperienceController extends Controller
{
    //

    public function index()
    {
    }

    public function show(Experience $experience)
    {

        $photo = $experience->photo;
        $userAuth = Auth::user();
        $address = $experience->address;
        $day = $experience->day;

        return view('experience.show', compact('experience', 'photo', 'address', 'userAuth', 'day'));
    }

    public function createExperience()
    {

        $categories = Category::all();
        $days = Day::all();
        $photo = Photo::all();
        return view('experience.createExperience', compact('categories', 'days', 'photo'));
    }

    public function edit()
    {
    }

    public function destroy(Experience $experience)
    {

        $orderIds = $experience->orderExperiences->pluck('order_id')->toArray();


        $experience->day()->delete();
        $experience->photo()->delete();

        OrderExperience::whereIn('order_id', $orderIds)->delete();

        $experience->delete();

        return redirect('/')->with('success', 'Experience deleted successfully');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'duration' => 'nullable|integer',
            'location' => 'required|string|max:50',
            'images' => 'array', // Ensure that 'photos' is an array
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each photo

        ]);

        $experience = new Experience();

        $experience->name = $request->input('name');
        $experience->description = $request->input('description');
        $experience->price = $request->input('price');
        $experience->category_id = $request->input('category_id');
        $experience->duration = $request->input('duration');
        $experience->location = $request->input('location');

        $experience->user_id = Auth::id();
        if (Auth::id()) {
            $user = User::find(Auth::id());
            $user->experience()->save($experience);
        }
        $experience->save();


        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $image->store('public/images'); // You can customize the storage path as needed
                // Create Photo model instance
                $photo = new Photo([
                    'name' => $image->getClientOriginalName(),
                    'path' => $image->hashName(),
                ]);

                // Associate the photo with the experience
                $experience->photo()->save($photo);
            }
        }

        $startDate = Carbon::tomorrow();
        $endDate = $startDate->copy()->addMonths(3);

        while ($startDate->lte($endDate)) {
            $day = strtolower($startDate->format('l'));

            if ($request->filled("schedule.$day")) {
                $timestamps = explode(',', $request->input("schedule.$day"));

                foreach ($timestamps as $timestamp) {
                    $timeframe = trim($timestamp);

                    $dayModel = new Day([
                        'experience_id' => $experience->id,
                        'date' => $startDate,
                        'timeframe' => $timeframe,
                        'max_people' => $request->input('max_people'),
                    ]);

                    // Save the day
                    $experience->day()->save($dayModel);
                }
            }

            // Move to the next day
            $startDate->addDay();
        }


        return redirect()->back()->with('success', 'Experience created successfully!');
    }

    public function update(Request $request, Experience $experience)
    {

        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'duration' => 'nullable|required|integer',
            'location' => 'required|string|max:50',

        ]);

        $experience->update($request->all());

        return redirect()->back()->with('success', 'Experience created successfully!');
    }

    public function checkAvailability(Request $request, $experience)
    {
          // Validate the input
    $request->validate([
        'selected_date' => 'required|date',
        'num_tickets' => 'required|integer|min:1',
    ]);

    $selectedDate = $request->input('selected_date');
    $numTickets = $request->input('num_tickets');

    // Query the database to find available timeframes for the specific experience
    $availableTimeframes = Day::where('experience_id', $experience)
        ->where('date', $selectedDate)
        ->where('max_people', '>=', $numTickets)
        ->whereRaw('(max_people - people_registered) >= ?', [$numTickets])
        ->pluck('timeframe');

    // Return the available timeframes as JSON
    return response()->json(['available_timeframes' => $availableTimeframes]);
    }

    public function showAvailability(Request $request, Experience $experience){

        return view('experience.showAvailability', compact('experience'));

    }
    
}
