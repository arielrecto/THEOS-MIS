<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(){

        $students = User::role(UserRoles::STUDENT->value)->get();


        $teachers = User::role(UserRoles::TEACHER->value)->get();

        return view('users.admin.users.index', compact(['students', 'teachers']));
    }
}
