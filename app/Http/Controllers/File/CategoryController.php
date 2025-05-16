<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\File;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filecategories =   Category::all();
        return view('file.category.index', compact('filecategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filecategories = Category::all();
        return view('file.category.create', compact('filecategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $fileCategory = new Category();
        $fileCategory->name = $request->input('name');
        $fileCategory->description = $request->input('description');
        $fileCategory->save();

        return redirect()->back()->with('success', 'File category created successfully.');
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $category = Category::with('files')->findOrFail($id);
        return view('file.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Category::find($id);
        return view('file.category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $fileCategory = Category::find($id);
        $fileCategory->name = $request->input('name');
        $fileCategory->description = $request->input('description');
        $fileCategory->save();

        return redirect()->back()->with('success', 'File category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fileCategory = Category::find($id);
        $fileCategory->delete();

        return redirect()->route('file-category.index')->with('success', 'File category deleted successfully.');
    }
}
