<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = $this->filteredPayments($request)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statuses = PaymentStatus::cases();

        $stats = [
            'total' => Payment::count(),
            'pending' => Payment::where('status', PaymentStatus::PENDING->value)->count(),
            'approved' => Payment::where('status', PaymentStatus::APPROVED->value)->count(),
            'rejected' => Payment::where('status', PaymentStatus::REJECTED->value)->count(),
        ];

        return view('users.admin.payments.index', compact('payments', 'stats', 'statuses'));
    }

    /**
     * Printable / PDF report of the payments matching the current index filters.
     */
    public function printList(Request $request)
    {
        $payments = $this->filteredPayments($request)->latest()->get();

        return view('users.admin.payments.print-list', compact('payments'));
    }

    /**
     * Payment query with the index page's filters applied (student search, status, date range).
     * Shared by the table and its PDF report so both always list the same payments.
     */
    private function filteredPayments(Request $request)
    {
        $request->validate([
            'status' => ['nullable', Rule::in(PaymentStatus::values())],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        return Payment::with(['user', 'paymentAccount'])
            ->when($request->filled('search'), fn($q) => $q->whereHas('user', fn($user) =>
                $user->where('name', 'like', "%{$request->search}%")
                     ->orWhere('email', 'like', "%{$request->search}%")
            ))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('created_at', '<=', $request->date_to));
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
