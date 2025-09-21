<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard(){


        $student = User::find(auth()->user()->id);

        return view('users.student.dashboard', compact('student'));
    }
}
