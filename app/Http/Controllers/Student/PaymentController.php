<?php

namespace App\Http\Controllers\Student;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $status = $this->statusFilter($request);

        $payments = $this->filteredPayments($status)
            ->paginate(10)
            ->withQueryString();

        // Summary cards always reflect every payment, regardless of the table filter.
        $summary = Payment::summaryFor(auth()->id());
        $totalPaid = $summary[PaymentStatus::APPROVED->value]['total'];

        return view('users.student.payments.index', compact('payments', 'summary', 'totalPaid', 'status'));
    }

    public function export(Request $request)
    {
        $payments = $this->filteredPayments($this->statusFilter($request))->get();

        $filename = 'payment-history-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($payments) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Date', 'Amount', 'Payment Method', 'Provider', 'Account Number', 'Status', 'Note']);

            foreach ($payments as $payment) {
                fputcsv($out, [
                    $payment->created_at->format('Y-m-d H:i'),
                    number_format($payment->amount, 2, '.', ''),
                    $payment->payment_method,
                    $payment->paymentAccount?->provider,
                    $payment->paymentAccount?->account_number,
                    PaymentStatus::tryFrom($payment->status)?->label() ?? $payment->status,
                    $payment->note,
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function statusFilter(Request $request): ?string
    {
        $request->validate(['status' => ['nullable', Rule::in(PaymentStatus::values())]]);

        return $request->status;
    }

    private function filteredPayments(?string $status)
    {
        return Payment::where('user_id', auth()->id())
            ->when($status, fn($query) => $query->where('status', $status))
            ->with(['paymentAccount'])
            ->latest();
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
            'status' => PaymentStatus::PENDING->value
        ]);

        return back()->with('success', 'Payment proof submitted successfully');
    }
}
