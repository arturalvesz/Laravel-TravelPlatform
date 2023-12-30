<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Experience;

class ProfileController extends Controller
{


    public function show(User $user)
    {
        $photo = $user->photo;
        $userAuth = Auth::user();
        $address = $user->address;
        $userExperiences = $user->experience()->distinct()->paginate(4);

        return view('profile.show', compact('user', 'photo', 'address', 'userAuth','userExperiences'));
    }

    public function edit()
    {

        $user = auth()->user();
        $photo = $user->photo;
        $address = $user->address;

        return view('profile.edit', compact('user', 'address', 'photo'));
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();

        // Validate the form data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'new_password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                function ($attribute, $value, $fail) use ($user) {
                    // Check if new_password is the same as the current password
                    if (Hash::check($value, $user->password)) {
                        $fail(__('The new password must be different from the current password.'));
                    }
                },
            ],  
        ]);

        // Update user information
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Update password if a new one is provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'User information updated successfully.');
    }

    public function storePhoto(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $user = Auth::user();

        $request->file('image')->store('public/images');
        $photo = new Photo();
        $photo->name = $request->file('image')->getClientOriginalName();
        $photo->path = $request->file('image')->hashName();

        $photo->user_id = $user->id;
        $photo->save();
        return redirect()->back()->with('success', 'Photo stored successfully');
    }

    public function updatePhoto(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $user = Auth::user();
        $prevPhoto = $user->photo;

        $request->file('image')->store('public/images');
        Storage::delete('storage/images' . $prevPhoto->path);
        $prevPhoto->delete();

        $photo = new Photo();
        $photo->name = $request->file('image')->getClientOriginalName();
        $photo->path = $request->file('image')->hashName();

        $photo->user_id = $user->id;
        $photo->save();
        return redirect()->back()->with('success', 'Photo updated successfully');
    }

    public function storeAddress(Request $request)
    {

        $request->validate([
            'country' => 'required|string|max:30',
            'district' => 'required|string|max:30',
            'city' => 'required|string|max:30',
            'street' => 'required|string|max:30',
            'postal_code' => 'required|string|max:30',
        ]);

        $address = new Address([
            'country' => $request->input('country'),
            'district' => $request->input('district'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'postal_code' => $request->input('postal_code'),
        ]);

        $user = Auth::user();
        $address->user_id = $user->id;

        $address->save();

        return Redirect::back()->with('success', 'Your address has been created successfully!');
    }

    public function updateAddress(Request $request)
    {

        $user = Auth::user();

        $address = $user->address;

        $request->validate([
            'country' => 'required|string|max:30',
            'district' => 'required|string|max:30',
            'city' => 'required|string|max:30',
            'street' => 'required|string|max:30',
            'postal_code' => 'required|string|max:30',
        ]);

        $address->update($request->all());
        return Redirect::back()->with('success', 'Your address has been updated successfully!');
    }
}
