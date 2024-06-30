<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomCategory;

class RoomCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = RoomCategory::all();
        return view('admin.room_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.room_categories.create');
    }

    /**
     * Store a newly created resource in storage.

     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = RoomCategory::create($validatedData);

        return redirect()->route('admin.room-categories.index')
            ->with('success', 'Room category created successfully.');
    }

    public function show($id)
    {
        $category = RoomCategory::findOrFail($id);
        return view('admin.room_categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = RoomCategory::findOrFail($id);
        return view('admin.room_categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = RoomCategory::findOrFail($id);
        $category->update($validatedData);

        return redirect()->route('admin.room-categories.index')
            ->with('success', 'Room category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = RoomCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.room-categories.index')
            ->with('success', 'Room category deleted successfully.');
    }
}
