<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentForm;
use App\Models\PaymentAccount;
use App\Models\Strand;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = EnrollmentForm::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('users.student.enrollment.index', compact('enrollments'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enrollment = EnrollmentForm::with(['attachments', 'academicYear'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        // Find strand based on grade_level
        $strand = Strand::with(['tuitionFees.bracket'])
            ->where('name', $enrollment->grade_level)
            ->orWhere('acronym', $enrollment->grade_level)
            ->first();

        $paymentAccounts = PaymentAccount::get();

        return view('users.student.enrollment.show', compact(
            'enrollment',
            'strand',
            'paymentAccounts'
        ));
    }
}
