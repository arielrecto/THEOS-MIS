<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentAccountController extends Controller
{
    public function index()
    {
        $accounts = PaymentAccount::latest()->paginate(10);
        return view('users.admin.payment-account.index', compact('accounts'));
    }

    public function create()
    {
        return view('users.admin.payment-account.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'qr_image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('qr_image')) {
            $path = $request->file('qr_image')->store('payment-qr', 'public');
            $validated['qr_image_path'] = $path;
        }

        PaymentAccount::create($validated);

        return redirect()
            ->route('admin.payment-accounts.index')
            ->with('success', 'Payment account created successfully');
    }

    public function show(PaymentAccount $paymentAccount)
    {
        return view('users.admin.payment-account.show', compact('paymentAccount'));
    }

    public function edit(PaymentAccount $paymentAccount)
    {
        return view('users.admin.payment-account.edit', compact('paymentAccount'));
    }

    public function update(Request $request, PaymentAccount $paymentAccount)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'qr_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('qr_image')) {
            // Delete old image
            if ($paymentAccount->qr_image_path) {
                Storage::disk('public')->delete($paymentAccount->qr_image_path);
            }
            
            $path = $request->file('qr_image')->store('payment-qr', 'public');
            $validated['qr_image_path'] = $path;
        }

        $paymentAccount->update($validated);

        return redirect()
            ->route('admin.payment-accounts.index')
            ->with('success', 'Payment account updated successfully');
    }

    public function destroy(PaymentAccount $paymentAccount)
    {
        if ($paymentAccount->qr_image_path) {
            Storage::disk('public')->delete($paymentAccount->qr_image_path);
        }
        
        $paymentAccount->delete();

        return redirect()
            ->route('admin.payment-accounts.index')
            ->with('success', 'Payment account deleted successfully');
    }
}
