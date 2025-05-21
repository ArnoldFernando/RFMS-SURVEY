<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\File;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::where('status', 'for_action')->get();
        return view('file.status.for-action', compact('files'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $files = File::where('status', 'action_completed')->get();
        return view('file.status.action-completed', compact('files'));
    }

    public function archived()
    {
        $files = File::where('status', 'archived')->get();
        return view('file.status.archived', compact('files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::all();
        $file = File::with(['category', 'user'])->find($id);
        return view('file.status.edit', compact('file', 'categories'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:for_action,action_completed,archived',
        ]);

        $file = File::findOrFail($id); // Replace File with your model class

        $file->status = $request->status;
        $file->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
