<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard ()
    {

        $user = Auth::user();



        return view('users.employee.dashboard', compact('user'));
    }
}
