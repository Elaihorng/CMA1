<?php

namespace App\Http\Controllers\backend;

use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product', 'user')->latest()->get();
        return view('backend.review.index', compact('reviews'));
    }
    
}
