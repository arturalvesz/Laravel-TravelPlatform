<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('id', 'asc')->paginate(10);

        return view('users.index', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $password = $request->input('password');
        $hashedPassword = Hash::make($password);
        $request->merge(['password'=> $hashedPassword]);
        User::create($request->all());
        return redirect()->back()->with('success', 'User stored successfully');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Update password if a new one is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    public function becomeLocal()
    {
        $user = auth()->user();
        $user->update(['usertype' => 'local']);

        return redirect()->back()->with('success', 'Photo updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function changeUserType(Request $request, User $user)
{
    $request->validate([
        'usertype' => 'required|in:admin,traveler,local', // Adjust the valid usertypes as needed
    ]);

    $user->update([
        'usertype' => $request->input('usertype'),
    ]);

    return redirect()->back()->with('success', 'Usertype changed successfully!');
}
}
