<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CMSController extends Controller
{
    public function index()
    {
        return view('users.admin.cms.index');
    }
}
