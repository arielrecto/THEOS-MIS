<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\EnrollmentForm;
use App\Models\PaymentAccount;
use App\Http\Controllers\Controller;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = EnrollmentForm::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('users.student.enrollment.index', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = EnrollmentForm::where('user_id', auth()->id())
            ->findOrFail($id);


        $paymentAccounts = PaymentAccount::all();

        return view('users.student.enrollment.show', compact('enrollment', 'paymentAccounts'));
    }
}
