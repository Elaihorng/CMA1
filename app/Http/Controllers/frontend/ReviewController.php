<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\Log;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
   

public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,product_id',
        'rating' => 'required|integer|min:1|max:5',
        'review_text' => 'nullable|string',
    ]);

    try {
        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        Log::info('Review created:', $review->toArray()); // ✅ logs to laravel.log
        // try dumping again

    } catch (\Exception $e) {
        Log::error('Review failed to save: ' . $e->getMessage());
        
    }

    return redirect()->back()->with('success', 'Thanks for your review!');
}


}
