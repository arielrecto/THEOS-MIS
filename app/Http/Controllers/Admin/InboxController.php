<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inbox;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inboxs = Inbox::latest()->paginate(10);
        return view('users.admin.inbox.index', compact('inboxs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Inbox::create($request->all());

        return back()->with(['success' => 'Message sent successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inbox = Inbox::findOrFail($id);
        $inbox->markAsRead();
        return view('users.admin.inbox.show', compact('inbox'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inbox = Inbox::findOrFail($id);
        $inbox->delete();

        return back()->with(['success' => 'Message deleted successfully.']);
    }


    public function markAsRead($id)
    {
        $message = Inbox::findOrFail($id);
        $message->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}
