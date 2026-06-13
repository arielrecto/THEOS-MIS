<?php

namespace App\Http\Controllers\Registrar;

use App\Models\AcademicYear;
use App\Models\EnrollmentForm;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enums\UserRoles;

class ReportController extends Controller
{
    public function index()
    {
        return view('users.registrar.report.index');
    }

    public function enrollment(Request $request)
    {
        $academicYears = AcademicYear::orderByDesc('id')->get();
        $selectedYear  = $request->filled('academic_year_id')
            ? AcademicYear::find($request->academic_year_id)
            : $academicYears->first();

        $query = EnrollmentForm::with(['user', 'academicYear'])
            ->when($selectedYear, fn($q) => $q->where('academic_year_id', $selectedYear->id))
            ->when($request->filled('grade_level'), fn($q) => $q->where('grade_level', $request->grade_level))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status));

        $enrollees = $query->orderBy('last_name')->get();

        $summary = [
            'total'    => $enrollees->count(),
            'approved' => $enrollees->where('status', 'approved')->count(),
            'pending'  => $enrollees->where('status', 'pending')->count(),
            'rejected' => $enrollees->where('status', 'rejected')->count(),
        ];

        $gradeLevels = ['Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4',
                        'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];

        $registrar = User::role(UserRoles::REGISTRAR->value)->first();
        $admin     = User::role(UserRoles::ADMIN->value)->first();

        return view('users.registrar.report.enrollment',
            compact('enrollees', 'academicYears', 'selectedYear', 'summary', 'gradeLevels', 'registrar', 'admin'));
    }

    public function payment(Request $request)
    {
        $academicYears = AcademicYear::orderByDesc('id')->get();
        $selectedYear  = $request->filled('academic_year_id')
            ? AcademicYear::find($request->academic_year_id)
            : $academicYears->first();

        $enrolleeIds = [];
        if ($selectedYear) {
            $enrolleeIds = EnrollmentForm::where('academic_year_id', $selectedYear->id)
                ->pluck('user_id')
                ->unique()
                ->filter()
                ->toArray();
        }

        $query = Payment::with(['user.studentProfile', 'paymentAccount'])
            ->when($selectedYear, fn($q) => $q->whereIn('user_id', $enrolleeIds))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('method'), fn($q) => $q->where('payment_method', $request->method));

        $payments = $query->orderBy('created_at', 'desc')->get();

        $summary = [
            'total_amount'   => $payments->where('status', 'approved')->sum('amount'),
            'total_count'    => $payments->count(),
            'approved_count' => $payments->where('status', 'approved')->count(),
            'pending_count'  => $payments->where('status', 'pending')->count(),
        ];

        $registrar = User::role(UserRoles::REGISTRAR->value)->first();
        $admin     = User::role(UserRoles::ADMIN->value)->first();

        return view('users.registrar.report.payment',
            compact('payments', 'academicYears', 'selectedYear', 'summary', 'registrar', 'admin'));
    }
}
