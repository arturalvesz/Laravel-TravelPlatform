<?php

namespace App\Http\Controllers\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Order;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StripeController extends Controller
{
    //

    public function checkout()
    {

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            // Redirect back to the cart page with a flash message
            return redirect()->route('cart.show')->with('cart_empty_message', 'Your cart is empty.');
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $totalPrice = 0;

        foreach ($cart as $item) {
            $experienceId = $item['experience_id'];
            $numTickets = $item['num_tickets'];
            $price = $item['price'];

            $totalPrice += $price;

            $experience = Experience::find($experienceId);

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $experience->name,
                    ],
                    'unit_amount' => ($price * 100)/$numTickets,
                ],
                'quantity' => $numTickets,
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel', [], true),
        ]);


        $order = new Order();
        $order->status = 'unpaid';
        $order->totalPrice = $totalPrice;
        $order->session_id = $session->id;
        $order->user_id = Auth::id();
        $order->save();

        return redirect($session->url);
    }



    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $sessionId = $request->get('session_id');

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);
            if (!$session) {
                throw new NotFoundHttpException;
            }
    
            $order = Order::where('session_id', $session->id)->where('status', 'unpaid')->first();
            if(!$order){
                throw new NotFoundHttpException;

            }

            $order->status = 'paid';
            $order->save();

            return view('checkout.success');

            } catch (\Exception $e) {
            throw new NotFoundHttpException;
        }
    }

    public function cancel()
    {
    }


    public function webhook(){

    }
}
