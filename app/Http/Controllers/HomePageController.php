<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Experience;


class HomePageController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $experiences = Experience::paginate(10);

        return view('homepage', compact('categories','experiences'));
    }
}
