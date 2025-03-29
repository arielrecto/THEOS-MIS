<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->roles()->first()->name;

        switch ($role) {
            case UserRoles::ADMIN->value:
                return to_route('admin.dashboard');
                break;
            case UserRoles::TEACHER->value:
                return to_route('teacher.dashboard');
                break;
            case UserRoles::REGISTRAR->value:
                return to_route('registrar.dashboard');
                break;
            case UserRoles::STUDENT->value:
                return to_route('student.dashboard');
                break;
            case UserRoles::HUMAN_RESOURCE->value:
                return to_route('hr.dashboard');
                break;
            default:
                return to_route('landing');
                break;
        }
    }
}
