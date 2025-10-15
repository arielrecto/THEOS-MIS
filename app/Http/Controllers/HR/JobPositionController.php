<?php

namespace App\Http\Controllers\HR;

use App\Models\JobPosition;
use App\Models\Department;
use App\Models\JobApplicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationStatusChanged;

class JobPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobPosition::query()->with('department');

        // Apply filters
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $positions = $query->latest()->paginate(12);
        $departments = Department::all();

        return view('users.hr.positions.index', compact('positions', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('users.hr.positions.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'min_salary' => 'required',
            'description' => 'required',
            'max_salary' => 'required',
            'status' => 'required',
            'type' => 'required',
        ]);


        JobPosition::create([
            ...$request->all(),
            'is_hiring' => $request->is_hiring == 'on' ? true : false,
        ]);


        return back()->with('success', 'Job Position created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = JobPosition::with([
            'department',
            'employees' => function ($query) {
                $query->with(['user', 'position'])
                    ->latest();
            },
            'applicants' => function ($query) {
                $query->with(['resume'])
                    ->latest();
            }
        ])
            ->withCount(['employees', 'applicants'])
            ->findOrFail($id);

        // Get application statistics
        $applicationStats = [
            'pending' => $position->applicants->where('status', 'pending')->count(),
            'approved' => $position->applicants->where('status', 'approved')->count(),
            'rejected' => $position->applicants->where('status', 'rejected')->count(),
        ];

        // Get monthly application trends
        $monthlyApplications = $position->applicants()
            ->whereYear('created_at', now()->year)
            ->get()
            ->groupBy(function ($application) {
                return $application->created_at->format('Y-m');
            })
            ->map(function ($applications) {
                return $applications->count();
            })
            ->toArray();

        return view('users.hr.positions.show', compact(
            'position',
            'applicationStats',
            'monthlyApplications'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $position = JobPosition::with('department')->findOrFail($id);
        $departments = Department::all();

        return view('users.hr.positions.edit', compact('position', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'type' => 'required|in:full-time,part-time,contract',
            'min_salary' => 'required|numeric|min:0',
            'max_salary' => 'required|numeric|gt:min_salary',
            'description' => 'required|string',
            'status' => 'required|in:active,draft,archived',
            'is_hiring' => 'boolean'
        ]);

        $position = JobPosition::findOrFail($id);

        $position->update([
            ...$validated,
            'is_hiring' => $request->has('is_hiring')
        ]);

        return redirect()
            ->route('hr.positions.show', $position)
            ->with('success', 'Position updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = JobPosition::findOrFail($id);

        $position->delete();


        return back()->with('success', 'Job Position deleted successfully.');
    }

    public function applicants(Request $request)
    {
        $query = JobApplicant::with(['position', 'resume'])
            ->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('position')) {
            $query->where('job_position_id', $request->position);
        }

        $applicants = $query->get();

        $positions = JobPosition::where('status', 'active')->get();

        return view('users.hr.positions.applicant.index', compact('applicants', 'positions'));
    }

    public function updateApplicantStatus(Request $request, JobApplicant $applicant)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,screening,interview,hired,rejected'
        ]);



        $oldStatus = $applicant->status;

        $applicant->update($validated);


        Mail::to($applicant->email)->send(
            new ApplicationStatusChanged(
                $applicant,
                $oldStatus,
                $validated['status'],
            )
        );

        return redirect()->back()->with('success', 'Applicant status updated successfully');
    }

    public function showApplicant($id)
    {

        $applicant = JobApplicant::findOrFail($id);

        return view('users.hr.positions.applicant.show', compact('applicant'));
    }

    public function toggleHiring($id)
    {

        $position = JobPosition::findOrFail($id);

        $position->update([
            'is_hiring' => !$position->is_hiring
        ]);

        return redirect()->back()->with(
            'success',
            $position->is_hiring
                ? 'Position is now accepting applications'
                : 'Position is no longer accepting applications'
        );
    }
}
