<?php

namespace App\Http\Controllers\Platform;

use App\Models\OrderExperiences;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Order;
use App\Models\OrderExperience;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Email;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Day;
use App\Mail\pdfMail;
use Illuminate\Support\Facades\Mail;

class StripeController extends Controller
{

    public function checkout()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $cart = session()->get('cart', []);
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
                    'unit_amount' => ($price * 100) / $numTickets,
                ],
                'quantity' => $numTickets,
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'customer_email' => Auth::user()-> email,
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

            $order = Order::where('session_id', $session->id)->first();

            if (!$order) {
                throw new NotFoundHttpException();
            }

            if ($order && $order->status == 'unpaid') {

                $order->status = 'paid';
            }

            $cart = session()->get('cart', []);



            foreach ($cart as $item) {
                $experienceId = $item['experience_id'];
                $numTickets = $item['num_tickets'];
                $price = $item['price'];

                $orderExperience = new OrderExperience();
                $orderExperience->order_id = $order->id;
                $orderExperience->experience_id = $experienceId;
                $orderExperience->num_tickets = $numTickets;
                $orderExperience->price = $price;
                $orderExperience->save();

                $day = Day::where('experience_id', $experienceId)
                    ->where('date', $item['selected_date'])
                    ->where('timeframe', $item['selected_timeframe'])
                    ->first();

                // Check if the day is found
                if ($day) {
                    // Update the people_registered attribute
                    $day->increment('people_registered', $numTickets);
                }
            }

            $order->save();

            $this->generatePDF($order, $cart);
            Mail::to(Auth::user()->email)->send(new pdfMail($order, $cart));


            session()->forget('cart');

            return view('checkout.success');
        } catch (\Exception $e) {
            throw new NotFoundHttpException;
        }
    }

    public function cancel()
    {
        return view('/');
    }

    public function webhook()
    {


        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $sessionId = $session->id;
                $order = Order::where('session_id', $session->id)->first();
                if ($order && $order->status == 'unpaid') {

                    $order->status = 'paid';
                    $order->save();
                }

            default:
                echo 'Received unknown event type' . $event->type;
        }

        return response('');
    }

    protected function generatePDF($order, $cart)
    {

        $pdf = PDF::loadView('ordersPDF.pdf', [
            'order' => $order,
            'cart' => $cart,
        ]);
        $slug = Str::slug($order->created_at, '-');
        $fileName = 'ordersPDF_' . $slug . '.pdf';
        $filePath = 'public/ordersPDF/' . $fileName;
        Storage::put($filePath, $pdf->output());
    }
}