<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())
            ->with(['paymentAccount'])
            ->latest()
            ->paginate(10);

        $totalPaid = Payment::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->sum('amount');

        return view('users.student.payments.index', compact('payments', 'totalPaid'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_account_id' => 'required|exists:payment_accounts,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'note' => 'nullable|string|max:255'
        ]);

        $path = $request->file('attachment')->store('payment-proofs', 'public');

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'payment_account_id' => $validated['payment_account_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'attachment' => $path,
            'note' => $validated['note'],
            'status' => 'pending'
        ]);

        return back()->with('success', 'Payment proof submitted successfully');
    }
}
