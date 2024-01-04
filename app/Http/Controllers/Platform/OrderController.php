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

    
}
