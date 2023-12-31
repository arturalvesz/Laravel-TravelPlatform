<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Redirect;

class AddressController extends Controller
{
    //

    public function index()
    {
        $addresses = Address::orderBy('id','asc')->paginate(10);

        return view('address.index', compact('addresses'));
    }

    public function show(Address $address)
    {
        return view('address.show', compact('address'));
    }
    public function create()
    {
        return view('address.create');
    }

    public function edit(Address $address)
    {
        return view('address.edit', compact('address'));
    }

    public function destroy(Address $address){

        $address->delete();

        return redirect()->back()->with('success', 'Address deleted successfully');
    }

    public function store(Request $request){

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

        $address->save();
        return Redirect::back()->with('success', 'Your address has been created successfully!');
    }

    public function update(Request $request, Address $address){
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
