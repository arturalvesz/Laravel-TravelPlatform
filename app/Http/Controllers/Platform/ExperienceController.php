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
use App\Models\Review;
use Illuminate\Support\Facades\DB;


class ExperienceController extends Controller
{
    //

    public function index()
    {
        $experiences = Experience::orderBy('id', 'asc')->paginate(5);

        return view('experience.index', compact('experiences'));
    }

    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        $days = Day::all();
        $photo = Photo::all();
        return view('experience.create', compact('categories', 'days', 'photo', 'users'));
    }

    public function show(Experience $experience)
    {

        $photo = $experience->photo;
        $userAuth = Auth::user();
        $address = $experience->address;
        $day = $experience->day;
        $reviews = Review::whereIn('order_experience_id', $experience->orderExperiences->pluck('id'))->paginate(5);
        

        return view('experience.show', compact('experience', 'photo', 'address', 'userAuth', 'day','reviews'));
    }

    public function createExperience()
    {

        $categories = Category::all();
        $days = Day::all();
        $photo = Photo::all();
        return view('experience.createExperience', compact('categories', 'days', 'photo'));
    }

    public function edit(Experience $experience)
    {
        $users = User::all();
        $categories = Category::all();

        return view('experience.edit', compact('experience', 'categories', 'users'));
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

        // Set the user_id if it is provided in the request
        if ($request->has('user_id')) {
            $experience->user_id = $request->input('user_id');
        } else {
            // Default to the authenticated user if user_id is not provided
            $experience->user_id = Auth::id();
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

        $timestampsValid = true;
        foreach ($request->input('schedule') as $day => $timestamps) {
            if (!strpos($timestamps, ',')) {
                $timestampsValid = true;
                break;
            }
        }
    
        if (!$timestampsValid) {

            $experience->delete();

            return redirect()->back()->with('error', 'Timestamps should be separated by commas.');
        }


        //Handle schedule creation
        $startDate = Carbon::tomorrow();
        $endDate = $startDate->copy()->addMonths(3);
        $hasScheduleEntries = false;


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

                    $hasScheduleEntries = true;

                }
            }
            // Move to the next day
            $startDate->addDay();
        }

        
        if (!$hasScheduleEntries) {
            // Rollback the transaction or delete the experience to ensure it's not saved without schedule entries
            $experience->delete();
            
            return redirect()->back()->with('error', 'Please provide at least one schedule entry.');
        }

        return redirect()->back()->with('success', 'Experience created successfully!');
    }

    public function updateExperience(Request $request, Experience $experience)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'user_id' => 'sometimes|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'duration' => 'nullable|integer',
            'location' => 'required|string|max:50',
        ]);

        $experience->update($request->all());


        return redirect()->back()->with('success', 'Experience updated successfully!');
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

        // Return the available timeframes
        return response()->json(['available_timeframes' => $availableTimeframes]);
    }
    
    public function showAvailability(Request $request, Experience $experience, $date)
    {
        $date = Carbon::parse($date);
    
        return view('experience.showAvailability', compact('experience', 'date'));
    }

    public function destroy(Experience $experience)
    {
        $orderIds = $experience->orderExperiences->pluck('order_id')->toArray();

        $experience->day()->delete();
        $experience->photo()->delete();

        OrderExperience::whereIn('order_id', $orderIds)->delete();

        $experience->delete();

        return redirect()->back()->with('success', 'Experience deleted successfully');
    }
}