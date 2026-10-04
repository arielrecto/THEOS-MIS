<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'paymentAccount'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Payment::count(),
            'pending' => Payment::where('status', PaymentStatus::PENDING->value)->count(),
            'approved' => Payment::where('status', PaymentStatus::APPROVED->value)->count(),
            'rejected' => Payment::where('status', PaymentStatus::REJECTED->value)->count(),
        ];

        return view('users.admin.payments.index', compact('payments', 'stats'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'paymentAccount']);
        return view('users.admin.payments.show', compact('payment'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([PaymentStatus::APPROVED->value, PaymentStatus::REJECTED->value])],
        ]);

        $payment->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment status updated successfully');
    }
}
