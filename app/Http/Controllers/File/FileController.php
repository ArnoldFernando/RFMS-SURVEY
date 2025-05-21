<?php

namespace App\Http\Controllers\File;

use App\Exports\AllFilesExport;
use App\Exports\FilesExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\File;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::with(['category', 'user'])->get();
        return view('file.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('file.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'file_name' => 'required|string|max:255',
        //     'location' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'file' => 'required|file|mimes:pdf,doc,docx,jpg,png',
        //     'civil_case_number' => 'required|string|max:255',
        //     'lot_number' => 'required|string|max:255',
        //     'path' => 'required|string|max:255',
        //     'status' => 'required|in:pending,approved,rejected,deleted',
        //     'file_category_id' => 'required|exists:file_categories,id',
        //     'user_id' => 'required|exists:users,id',
        // ]);

        // Upload the file
        $filePath = $request->file('file')->store('files', 'public');

        File::create([
            'file_name' => $request->file_name,
            'location' => $request->location,
            'description' => $request->description,
            'file' => $filePath,
            'civil_case_number' => $request->civil_case_number,
            'lot_number' => $request->lot_number,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('file.create')->with('success', 'File uploaded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::all();
        $file = File::with(['category', 'user'])->find($id);
        return view('file.edit', compact('file', 'categories'));
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

        return redirect()->route('file.index')->with('success', 'File updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function downloadFile($id)
    {
        $file = File::findOrFail($id);
        $path = storage_path('app/public/' . $file->file);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        // Ensure the filename has the correct extension
        $originalExtension = pathinfo($path, PATHINFO_EXTENSION);
        $customFileName = $file->file_name . '.' . $originalExtension;

        return response()->download($path, $customFileName);
    }


    public function exportByStatus(Request $request)
    {
        $status = $request->query('status');

        if (!in_array($status, ['for_action', 'action_completed', 'archived'])) {
            return redirect()->back()->with('error', 'Invalid status selected.');
        }

        return Excel::download(new FilesExport($status), "files_{$status}.xlsx");
    }

    public function exportAllFiles()
    {
        return Excel::download(new AllFilesExport, 'all_files.xlsx');
    }
}
