<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Experience;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        $categories = Category::all();
        $experiences = Experience::with(['reviews' => function ($query) {
            $query->select('experience_id', DB::raw('AVG(starRating) as average_rating'))
                ->groupBy('experience_id');
        }])->paginate(10);
        

        return view('homepage', compact('categories','experiences'));
    }
}
