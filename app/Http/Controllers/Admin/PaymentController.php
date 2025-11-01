<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'paymentAccount'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Payment::count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'approved' => Payment::where('status', 'approved')->count(),
            'rejected' => Payment::where('status', 'rejected')->count(),
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
            'status' => 'required|in:approved,rejected'
        ]);

        $payment->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment status updated successfully');
    }
}
