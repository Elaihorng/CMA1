<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // Check if the user is a customer
        if ($user->roles->first()->name === 'customer') {
            abort(403, 'Access denied. Customers are not allowed to access the admin dashboard.');
        }

        return view('backend.dashboard.index');
    }
}
