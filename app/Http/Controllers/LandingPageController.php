<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralAnnouncement;

class LandingPageController extends Controller
{
    public function index()
    {

        $announcements = GeneralAnnouncement::latest()->paginate(6);

        return view('welcome', compact('announcements'));
    }

    public function contact(){
        return view('components.landing-page.contact-us');
    }

    public function gallery(){
        return view('components.landing-page.gallery');
    }

    public function about(){
        return view('components.landing-page.about-us');
    }
    public function enrolleesForm(){
        return view('enrollees.form');
    }
}
