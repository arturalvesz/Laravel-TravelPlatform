<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experience;

class CartController extends Controller
{
    public function showCart()
    {
        // Retrieve the current cart from the session
        $cart = session()->get('cart', []);

        // You can pass $cart to the cart blade file for display
        return view('cart.show', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $numTickets = $request->input('numTickets');
        $selectedDate = $request->input('selectedDate');
        $selectedTimeframe = $request->input('selectedTimeframe');
        $experienceId = $request->input('experience_id');
        $experiencePrice = $request->input('experience_price');

        // Perform any necessary calculations or validations here
        $totalPrice = $experiencePrice * $numTickets;

        // Get the current cart or create an empty array
        $cart = session()->get('cart', []);

        $itemId = uniqid();

        // Add the new item to the cart
        $cart[] = [
            'id' => $itemId,
            'experience_id' => $experienceId,
            'num_tickets' => $numTickets,
            'selected_date' => $selectedDate,
            'selected_timeframe' => $selectedTimeframe,
            'price' => $totalPrice,
        ];

        // Save the updated cart to the session
        session(['cart' => $cart]);
        // Redirect to the cart view
        return redirect()->route('cart.show');
    }

    public function removeExperienceFromCart(Request $request)
{
    $itemIdToRemove = $request->input('item_id');
    // Get the current cart or create an empty array
    $cart = session()->get('cart', []);

    // Create a new array without the item to be removed
    $newCart = [];
    foreach ($cart as $item) {
        // Check if the item's id matches the id to be removed
        if ($item['id'] != $itemIdToRemove) {
            $newCart[] = $item;
        }
    }

    // Save the updated cart to the session
    session(['cart' => $newCart]);

    // Redirect to the cart view
    return redirect()->route('cart.show');
}



}