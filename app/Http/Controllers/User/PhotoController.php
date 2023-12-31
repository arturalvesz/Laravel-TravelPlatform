<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use App\Models\Experience;
class PhotoController extends Controller
{
    //
    public function index(Request $request)
    {
        $photos = Photo::orderBy('id', 'asc')->paginate(10);

        return view('photo.index', compact('photos'));
    }

    public function show(Photo $photo)
    {
        return view('photo.show', compact('photo'));
    }

    public function create()
    {
        $experiences = Experience::all();
        return view('photo.create', compact('experiences'));
    }

    public function edit(Photo $photo)
    {
        return view('photo.edit', compact('photo'));
    }

    public function destroy(Photo $photo)
    {

        Storage::delete('storage/images' . $photo->path);
        $photo->delete();
        return redirect()->back()->with('success', 'Photo deleted successfully');
    }

    public function storePhoto(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'experience_id' => 'required|exists:experiences,id',
        ]);

        

        $request->file('image')->store('public/images');
        $photo = new Photo();
        $photo->name = $request->file('image')->getClientOriginalName();
        $photo->path = $request->file('image')->hashName();

        $photo->experience_id = $request->input('experience_id');
        $photo->save();
        return redirect()->back()->with('success', 'Photo stored successfully');
    }

    public function update(Request $request, Photo $photo)
    {

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
