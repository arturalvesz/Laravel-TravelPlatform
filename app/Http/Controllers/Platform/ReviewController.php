<?php

namespace App\Http\Controllers\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\OrderExperience;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ReviewController extends Controller
{
    //

    public function create(OrderExperience $order_experience, Experience $experience)
    {
        return view('review.create', compact('order_experience', 'experience'));
    }


    public function store(Request $request)
    {

        $user = Auth::user();

        $existingReview = Review::where('user_id', $user->id)->where('order_experience_id', $request->order_experience_id)->first();

        $orderExperience = OrderExperience::find($request->order_experience_id);

        $order_id = $orderExperience->order_id;

        if ($existingReview) {
            return redirect()->route('orders.show', $order_id)->with('error', 'You have already submitted a review for this experience.');
        }

        $request->validate([
            'order_experience_id' => 'required|nullable|integer',
            'starRating' => 'required|between:0,5',
            'comment' => 'required|string|max:250',
        ]);

        $orderExperience = OrderExperience::find($request->order_experience_id);

        $order_id = $orderExperience->order_id;


        $review = new Review();

        $review->user_id = $user->id; 

        $review->order_experience_id = $request->input('order_experience_id');
        $review->starRating = $request->input('starRating');
        $review->comment = $request->input('comment');

        $review->save();

        return redirect()->route('orders.show', $order_id)->with('success', 'Review submitted successfully!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }

    public function index()
    {
        $reviews = Review::with(['user', 'orderExperience.experience'])->paginate(5);

        return view('review.index', compact('reviews'));
    }
}
