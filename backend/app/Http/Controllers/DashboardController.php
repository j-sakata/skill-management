<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    /**
     * Show the dashboard screen.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        return Inertia::render('Dashboard', ['user_id' => $user_id]);
    }
}
