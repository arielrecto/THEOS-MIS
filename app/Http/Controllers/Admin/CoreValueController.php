<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoreValue;
use App\Models\CoreValueItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CoreValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coreValues = CoreValue::withCount('items')->latest()->paginate(10);
        return view('users.admin.cms.core-value.index', compact('coreValues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.cms.core-value.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
            'items' => 'nullable|array',
            'items.*.item_name' => 'required_with:items|string|max:255',
            'items.*.item_description' => 'required_with:items|string',
            'items.*.is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // If this core value is set to active, deactivate all others
            if ($request->boolean('is_active')) {
                CoreValue::where('is_active', true)->update(['is_active' => false]);
            }

            $coreValue = CoreValue::create([
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->boolean('is_active'),
            ]);

            // Create core value items if provided
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    if (!empty($item['item_name']) && !empty($item['item_description'])) {
                        $coreValue->items()->create([
                            'item_name' => $item['item_name'],
                            'item_description' => $item['item_description'],
                            'is_active' => isset($item['is_active']) ? true : false,
                        ]);
                    }
                }
            }

            DB::commit();
            return back()
                ->with('success', 'Core value created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create core value: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CoreValue $coreValue)
    {
        $coreValue->load('items');
        return view('users.admin.cms.core-value.show', compact('coreValue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoreValue $coreValue)
    {
        $coreValue->load('items');
        return view('users.admin.cms.core-value.edit', compact('coreValue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoreValue $coreValue)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
            'items' => 'nullable|array',
            'items.*.item_name' => 'required_with:items|string|max:255',
            'items.*.item_description' => 'required_with:items|string',
            'items.*.is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // If this core value is set to active, deactivate all others
            if ($request->boolean('is_active') && !$coreValue->is_active) {
                CoreValue::where('is_active', true)
                    ->where('id', '!=', $coreValue->id)
                    ->update(['is_active' => false]);
            }

            $coreValue->update([
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->boolean('is_active'),
            ]);

            // Delete existing items and recreate
            $coreValue->items()->delete();

            // Create new items if provided
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    if (!empty($item['item_name']) && !empty($item['item_description'])) {
                        $coreValue->items()->create([
                            'item_name' => $item['item_name'],
                            'item_description' => $item['item_description'],
                            'is_active' => isset($item['is_active']) ? true : false,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.core-values.index')
                ->with('success', 'Core value updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update core value: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoreValue $coreValue)
    {
        DB::beginTransaction();
        try {
            // Delete all associated items
            $coreValue->items()->delete();

            // Delete the core value
            $coreValue->delete();

            DB::commit();
            return redirect()->route('admin.core-values.index')
                ->with('success', 'Core value deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to delete core value: ' . $e->getMessage());
        }
    }

    /**
     * Toggle active status
     */
    public function toggleActive(CoreValue $coreValue)
    {
        // If activating this core value, deactivate all others
        if (!$coreValue->is_active) {
            CoreValue::where('is_active', true)->update(['is_active' => false]);
            $coreValue->update(['is_active' => true]);
            $message = 'Core value activated successfully.';
        } else {
            $coreValue->update(['is_active' => false]);
            $message = 'Core value deactivated successfully.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Delete a specific item
     */
    public function deleteItem(CoreValueItem $item)
    {
        $item->delete();
        return redirect()->back()->with('success', 'Core value item deleted successfully.');
    }

    /**
     * Toggle item active status
     */
    public function toggleItemActive(CoreValueItem $item)
    {
        $item->update(['is_active' => !$item->is_active]);
        $message = $item->is_active ? 'Item activated successfully.' : 'Item deactivated successfully.';
        return redirect()->back()->with('success', $message);
    }
}
