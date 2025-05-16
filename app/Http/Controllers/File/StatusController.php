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
    public function update(Request $request, File $file)
    {
        // $request->validate([
        //     'file_name' => 'string|max:255',
        //     'location' => 'string|max:255',
        //     'description' => 'nullable|string',
        //     'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        //     'civil_case_number' => 'string|max:255',
        //     'lot_number' => 'string|max:255',
        //     'path' => 'string|max:255',
        //     'status' => 'in:for_action,action_completed,archived',
        //     'category_id' => 'categories,id',
        //     'user_id' => auth()->id(),
        // ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('files', 'public');
            $file->file = $filePath;
        }

        $file->update($request->except(['file']));

        return redirect()->intended()->with('success', 'File updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
