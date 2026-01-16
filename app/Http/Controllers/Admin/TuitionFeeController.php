<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TuitionFee;
use App\Models\TuitionFeeBracket;
use Illuminate\Http\Request;

class TuitionFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brackets = TuitionFeeBracket::with('fees')->latest()->get();
        return view('users.admin.tuition-fee.index', compact('brackets'));
    }

    // ============ BRACKET OPERATIONS ============

    /**
     * Store a newly created bracket.
     */
    public function storeBracket(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        TuitionFeeBracket::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.tuition-fee.index')
            ->with('success', 'Fee bracket created successfully');
    }

    /**
     * Update the specified bracket.
     */
    public function updateBracket(Request $request, TuitionFeeBracket $bracket)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $bracket->update($validated);

        return redirect()
            ->route('admin.tuition-fee.index')
            ->with('success', 'Fee bracket updated successfully');
    }

    /**
     * Toggle bracket active status.
     */
    public function toggleBracket(TuitionFeeBracket $bracket)
    {
        $bracket->update(['is_active' => !$bracket->is_active]);

        return redirect()
            ->route('admin.tuition-fee.index')
            ->with('success', 'Bracket status updated successfully');
    }

    /**
     * Remove the specified bracket.
     */
    public function destroyBracket(TuitionFeeBracket $bracket)
    {
        // Delete all associated fees first
        $bracket->fees()->delete();

        // Then delete the bracket
        $bracket->delete();

        return redirect()
            ->route('admin.tuition-fee.index')
            ->with('success', 'Fee bracket and all associated fees deleted successfully');
    }

    // ============ FEE OPERATIONS ============

    /**
     * Store a newly created fee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Tuition,Miscellaneous,Other',
            'amount' => 'required|numeric|min:0',
            'payment_agreement' => 'required|string|in:full,installment',
            'is_monthly' => 'nullable|boolean',
            'is_onetime_fee' => 'nullable|boolean',
            'tuition_fee_bracket_id' => 'required|exists:tuition_fee_brackets,id',
        ]);

        TuitionFee::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'payment_agreement' => $validated['payment_agreement'],
            'is_monthly' => $request->has('is_monthly'),
            'is_onetime_fee' => $request->has('is_onetime_fee'),
            'tuition_fee_bracket_id' => $validated['tuition_fee_bracket_id'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.tuition-fee.index')
            ->with('success', 'Fee added successfully');
    }

    /**
     * Update the specified fee.
     */
    public function update(Request $request, TuitionFee $fee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Tuition,Miscellaneous,Other',
            'amount' => 'required|numeric|min:0',
            'payment_agreement' => 'required|string|in:full,installment',
            'is_monthly' => 'nullable|boolean',
            'is_onetime_fee' => 'nullable|boolean',
        ]);

        $fee->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'payment_agreement' => $validated['payment_agreement'],
            'is_monthly' => $request->has('is_monthly'),
            'is_onetime_fee' => $request->has('is_onetime_fee'),
        ]);

        return redirect()
            ->route('admin.tuition-fee.index')
            ->with('success', 'Fee updated successfully');
    }

    /**
     * Toggle fee active status.
     */
    public function toggle(TuitionFee $fee)
    {
        $fee->update(['is_active' => !$fee->is_active]);

        return redirect()
            ->route('admin.tuition-fee.index')
            ->with('success', 'Fee status updated successfully');
    }

    /**
     * Remove the specified fee.
     */
    public function destroy($id)
    {

        $fee = TuitionFee::findOrFail($id);

        $fee->delete();

        return redirect()
            ->route('admin.tuition-fee.index')
            ->with('success', 'Fee deleted successfully');
    }
}
