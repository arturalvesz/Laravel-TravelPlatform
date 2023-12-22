<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function becomeLocal()
    {
        $user = auth()->user();
        $user->update(['usertype' => 'local']);

        return redirect()->back()->with('success', 'Photo updated successfully');
    }
}
