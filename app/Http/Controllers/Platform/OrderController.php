<?php

namespace App\Http\Controllers\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //

    public function show(Order $order){
        $experiences= Experience::all();
        return view ('orders.show', compact('order', 'experiences'));
    }

    public function index(){
        $user = Auth::user();
        $orders = Order::Where('user_id', $user->id)->paginate(10);

        return view ('orders.index', compact ('orders'));
    }
}
