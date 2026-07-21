<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laboratory;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLabs = Laboratory::count();
        $totalBookings = Booking::count();
        $totalUsers = User::count();
        $recentBookings = Booking::with(['laboratory'])->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalLabs', 'totalBookings', 'totalUsers', 'recentBookings'));
    }
}
