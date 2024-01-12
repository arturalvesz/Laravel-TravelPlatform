<?php

namespace App\Http\Controllers\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
class OrderController extends Controller
{
    //

    public function show(Order $order)
    {
        $experiences = Experience::all();
        return view('orders.show', compact('order', 'experiences'));
    }

    public function index()
    {
        $user = Auth::user();
        $orders = Order::Where('user_id', $user->id)->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function adminIndex()
    {
        $orders = Order::orderBy('id', 'asc')->paginate(10);

        return view('orders.index', compact('orders'));
    }
    
    public function downloadPDF($order_id)
    {

        $order = Order::find($order_id);
        $slug = Str::slug($order->created_at, '-');
        $fileName = 'ordersPDF_' . $slug . '.pdf';
        $path = storage_path('app/public/ordersPDF/' . $fileName);
        return response()->download($path, 'ordersPDF_'. $fileName.'.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
    
    public function sales()
    {
        $user = Auth::user();
        $experiences = Experience::all();

        // Retrieve all experiences created by the authenticated user
        $userExperiences = Experience::where('user_id', $user->id)->pluck('id');

        // Retrieve orders that have experiences created by the authenticated user through the pivot table
        $orders = Order::whereHas('orderExperiences', function ($query) use ($userExperiences) {
            $query->whereIn('experience_id', $userExperiences);
        })->with(['orderExperiences', 'orderExperiences.experience', 'user'])->paginate(8);

        return view('orders.salesIndex', compact('orders', 'experiences'));
    }
}