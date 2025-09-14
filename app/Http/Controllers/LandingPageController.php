<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Gallery;
use App\Models\Department;
use App\Models\JobPosition;
use Illuminate\Http\Request;
use App\Models\AcademicProgram;
use App\Models\GeneralAnnouncement;

class LandingPageController extends Controller
{
    public function index()
    {
        $announcements = GeneralAnnouncement::where('is_posted', true)->latest()->paginate(6);

        $programs = AcademicProgram::where('is_active', true)->latest()->get();

        return view('welcome', [
            'announcements' => $announcements,
            'programs' => $programs
        ]);
    }

    public function contact()
    {
        return view('components.landing-page.contact-us');
    }

    public function gallery(Request $request)
    {
        $galleries = Gallery::where('is_active', true)
            ->latest()
            ->get()
            ->map(function($gallery) {
                return [
                    'id' => $gallery->id,
                    'url' => asset('storage/' . $gallery->path),
                    'title' => $gallery->name,
                    'description' => $gallery->description,
                    'date' => $gallery->created_at->format('F Y'),
                    'category' => 'School Events' // You can add category field to Gallery model if needed
                ];
            });




        if($request->category){
            $galleries = Gallery::where('is_active', true)
            ->where('category', strtolower($request->category)  )
            ->latest()
            ->get()
            ->map(function($gallery) {
                return [
                    'id' => $gallery->id,
                    'url' => asset('storage/' . $gallery->path),
                    'title' => $gallery->name,
                    'description' => $gallery->description,
                    'date' => $gallery->created_at->format('F Y'),
                    'category' => 'School Events' // You can add category field to Gallery model if needed
                ];
            });
        }


        return view('components.landing-page.gallery', [
            'galleries' => $galleries
        ]);
    }

    public function about()
    {
        $aboutUs = AboutUs::first();
        return view('components.landing-page.about-us', compact('aboutUs'));
    }

    public function enrolleesForm()
    {
        return view('enrollees.form');
    }

    public function jobOpportunities(Request $request)
    {
        $query = JobPosition::with('department')->where('is_hiring', true)->where('status', 'active');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $jobs = $query->latest()->paginate(6);
        $departments = Department::all();

        return view('components.landing-page.job', compact('jobs', 'departments'));
    }

    public function showJob(JobPosition $position)
    {
        if (!$position->is_hiring || $position->status !== 'active') {
            abort(404);
        }

        return view('components.landing-page.job-show', compact('position'));
    }

    public function applyJob(Request $request, JobPosition $position)
    {
        if (!$position->is_hiring || $position->status !== 'active') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'linkedin' => 'nullable|url|max:255',
            'portfolio' => 'nullable|url|max:255',
            'cover_letter' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        $applicant = $position->applicants()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            // 'linkedin' => $validated['linkedin'],
            // 'portfolio' => $validated['portfolio'],
            'cover_letter' => $validated['cover_letter'],
        ]);

        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $applicant->resume()->create([
                'file_dir' => asset('storage/' . $path),
                'file_name' => $request->file('resume')->getClientOriginalName(),
                'file_type' => $request->file('resume')->getClientMimeType(),
                'file_size' => $request->file('resume')->getSize(),
                'attachable_id' => $applicant->id,
                'attachable_type' => get_class($applicant),
            ]);
        }

        return back()->with('success', 'Your application has been submitted successfully!');
    }


    public function generalAnnouncementShow(string $id){
        $announcement = GeneralAnnouncement::findOrFail($id);

        return view('general-announcement.show', compact('announcement'));
    }
}
