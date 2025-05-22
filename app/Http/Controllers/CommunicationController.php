<?php

namespace App\Http\Controllers;

use App\Exports\CommunicationsByStatusExport;
use App\Exports\CommunicationsExport;
use App\Models\Communication;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = Communication::with('user')->get();
        return view('communication.index', compact('files'));
    }

    public function incoming()
    {
        $files = Communication::where('status', 'in_coming')->get();
        return view('communication.incoming', compact('files'));
    }

    public function outgoing()
    {
        $files = Communication::where('status', 'out_going')->get();
        return view('communication.outgoing', compact('files'));
    }
    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('Communication.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string',
            'tracking_number' => 'required|string',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|file',  // make file nullable here
            'status' => 'required|string',
        ]);
        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('files', 'public');
        }

        Communication::create([
            'file_name' => $request->file_name,
            'tracking_number' => $request->tracking_number,
            'location' => $request->location,
            'description' => $request->description,
            'file' => $filePath,  // will be null if no file uploaded
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);


        return redirect()->route('communication.create')->with('success', 'File uploaded successfully');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string',
            'tracking_number' => 'required|string',
            'location' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $file = Communication::findOrFail($request->id);
        $file->update([
            'file_name' => $request->file_name,
            'tracking_number' => $request->tracking_number,
            'location' => $request->location,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'File updated successfully!');
    }

    public function downloadFile($id)
    {
        $file = Communication::findOrFail($id);
        $path = storage_path('app/public/' . $file->file);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        // Ensure the filename has the correct extension
        $originalExtension = pathinfo($path, PATHINFO_EXTENSION);
        $customFileName = $file->file_name . '.' . $originalExtension;

        return response()->download($path, $customFileName);
    }

    public function exportCommunications()
    {
        return Excel::download(new CommunicationsExport, 'communications.xlsx');
    }

    public function exportCommunicationsByStatus($status)
    {
        return Excel::download(new CommunicationsByStatusExport($status), "communications_{$status}.xlsx");
    }
}
