<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Floor;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $floors = Floor::all();
        return view('admin.floors.index', compact('floors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.floors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'floor_name' => 'required|string|max:255',
            'floor_description' => 'nullable|string',
        ]);

        $floor = Floor::create($validatedData);

        return redirect()->route('admin.floors.index')
            ->with('success', 'Floor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $floor = Floor::findOrFail($id);
        return view('admin.floors.show', compact('floor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $floor = Floor::findOrFail($id);
        return view('admin.floors.edit', compact('floor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'floor_name' => 'required|string|max:255',
            'floor_description' => 'nullable|string',
        ]);

        $floor = Floor::findOrFail($id);
        $floor->update($validatedData);

        return redirect()->route('admin.floors.index')
            ->with('success', 'Floor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $floor = Floor::findOrFail($id);
        $floor->delete();

        return redirect()->route('admin.floors.index')
            ->with('success', 'Floor deleted successfully.');
    }
}
