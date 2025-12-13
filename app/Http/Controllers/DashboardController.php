<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRestaurant;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Admin.dashboard');
    }
}
