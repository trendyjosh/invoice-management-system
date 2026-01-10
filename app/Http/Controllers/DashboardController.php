<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): Response
    {
        $dashboardStats = User::getDashboardStats();

        return Inertia::render('Dashboard/Index', [
            'stats' => $dashboardStats,
        ]);
    }
}
