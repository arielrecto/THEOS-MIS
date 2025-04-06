<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Actions\NotificationActions;
use App\Http\Controllers\Controller;

class AcademicYearController extends Controller
{
    protected $notificationActions;

    public function __construct(NotificationActions $notificationActions)
    {
        $this->notificationActions = $notificationActions;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicYears = AcademicYear::paginate(10);
        return view('users.admin.academic-year.index', compact('academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.academic-year.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $academicYear = AcademicYear::create([
            'name' => "Academic Year " . date('Y', strtotime($request->start_date)) . " - " . date('Y', strtotime($request->end_date)),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
        ]);

        // Notify admin and teachers about new academic year
        $notificationData = [
            'header' => 'New Academic Year Created',
            'message' => $academicYear->generateNotificationMessage($academicYear, 'created'),
            'type' => 'info',
            'url' => route('admin.academic-year.index')
        ];

        $this->notificationActions->notifyRoles(['admin', 'teacher', 'registrar'], $notificationData, $academicYear);

        return redirect()
            ->route('admin.academic-year.index')
            ->with('success', 'Academic Year created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $academicYear = AcademicYear::with([
            'enrollments',
            'enrollees',
            'academicRecords.grades',
        ])->findOrFail($id);

        // Calculate statistics
        $totalRecords = $academicYear->academicRecords->count();
        $passingCount = $academicYear->academicRecords->filter(function($record) {
            return $record->average >= 75;
        })->count();

        // Get enrollment periods statistics
        $enrollmentPeriods = $academicYear->enrollments->groupBy('status');
        $ongoingPeriods = $enrollmentPeriods->get('On Going', collect())->count();
        $completedPeriods = $enrollmentPeriods->get('Completed', collect())->count();

        // Get enrollment statistics by grade level
        $enrollmentsByGradeLevel = $academicYear->enrollees
            ->groupBy('grade_level')
            ->map(function($enrollees) {
                return [
                    'total' => $enrollees->count(),
                    'approved' => $enrollees->where('status', 'approved')->count(),
                    'pending' => $enrollees->where('status', 'pending')->count()
                ];
            });

        // Get academic performance by grade level
        $performanceByGradeLevel = $academicYear->academicRecords
            ->groupBy('grade_level')
            ->map(function($records) {
                return [
                    'total' => $records->count(),
                    'average' => $records->avg('average'),
                    'passing' => $records->filter(fn($r) => $r->average >= 75)->count(),
                    'failing' => $records->filter(fn($r) => $r->average < 75)->count()
                ];
            });

        return view('users.admin.academic-year.show', compact(
            'academicYear',
            'totalRecords',
            'passingCount',
            'ongoingPeriods',
            'completedPeriods',
            'enrollmentsByGradeLevel',
            'performanceByGradeLevel'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return view('users.admin.academic-year.edit', compact('academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $oldStatus = $academicYear->status;
        $newStatus = $request->has('status') ? 'active' : 'inactive';

        // If this is being set as active, deactivate all others
        if ($newStatus === 'active') {
            AcademicYear::where('id', '!=', $academicYear->id)
                ->update(['status' => 'inactive']);
        }

        $academicYear->update([
            'name' => "Academic Year " . date('Y', strtotime($request->start_date)) . " - " . date('Y', strtotime($request->end_date)),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $newStatus,
        ]);

        // Prepare notification data
        $notificationData = [
            'header' => 'Academic Year Updated',
            'message' => $academicYear->generateNotificationMessage($academicYear,
                $oldStatus !== $newStatus ? ($newStatus === 'active' ? 'activated' : 'deactivated') : 'updated'
            ),
            'type' => 'info',
            'url' => route('admin.academic-year.index')
        ];

        // Notify relevant users
        $this->notificationActions->notifyRoles(['admin', 'teacher'], $notificationData, $academicYear);

        return redirect()
            ->route('admin.academic-year.index')
            ->with('success', 'Academic Year updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        // Prepare notification before deletion
        $notificationData = [
            'header' => 'Academic Year Deleted',
            'message' => $academicYear->generateNotificationMessage($academicYear, 'deleted'),
            'type' => 'warning',
            'url' => route('admin.academic-year.index')
        ];

        $academicYear->delete();

        // Notify after successful deletion
        $this->notificationActions->notifyRoles(['admin', 'teacher'], $notificationData);

        return redirect()
            ->route('admin.academic-year.index')
            ->with('success', 'Academic Year deleted successfully');
    }
}
