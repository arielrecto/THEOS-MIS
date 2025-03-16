<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Classroom;

class DashboardController extends Controller
{
    public function dashboard (){


        $total_users = User::whereHas('roles', function($q) {
            $q->where('name', '!=', UserRoles::ADMIN->value);
        })->count();

        $total_classrooms = Classroom::count();

        $total_students = User::whereHas('roles', function($q) {
            $q->where('name', UserRoles::STUDENT->value);
        })->count();



        return view('users.admin.dashboard', compact(['total_users', 'total_classrooms', 'total_students']));
    }
}
