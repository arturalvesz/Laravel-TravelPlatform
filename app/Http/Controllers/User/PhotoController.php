<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    //
    public function index(){}

    public function show(){}

    public function create(){}

    public function edit(){}

    public function destroy(Photo $photo){

        Storage::delete('storage/images' . $photo->path);
        $photo->delete();
        return redirect()->back()->with('success', 'Photo deleted successfully');
    }

    public function store(Request $request){

        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $request->file('image')->store('public/images');
        $photo = new Photo();
        $photo->name = $request->file('image')->getClientOriginalName();
        $photo->path = $request->file('image')->hashName();
        $photo->save();
        return redirect()->back()->with('success', 'Photo stored successfully');
    }


    public function update(Request $request, Photo $photo){

        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);
        Storage::delete('storage/images' . $photo->path);
        $request->file('image')->store('public/images');
    
        $photo->name = $request->file('image')->getClientOriginalName();
        $photo->path = $request->file('image')->hashName();
        $photo->save();
        return redirect()->back()->with('success', 'Photo stored successfully');
    }

}
