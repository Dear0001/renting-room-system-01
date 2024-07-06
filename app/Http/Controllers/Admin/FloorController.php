<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Floor;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::all();
        return view('floors.index', compact('floors'));
    }

    public function create()
    {
        return view('floors.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'floor_name' => 'required|string|max:255',
            'floor_description' => 'nullable|string',
        ]);

        $floor = Floor::create($validatedData);

        return redirect()->route('floors.index')
            ->with('success', 'Floor created successfully.');
    }

    public function show($id)
    {
        $floor = Floor::findOrFail($id);
        return view('floors.show', compact('floor'));
    }

    public function edit($id)
    {
        $floor = Floor::findOrFail($id);
        return view('floors.edit', compact('floor'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'floor_name' => 'required|string|max:255',
            'floor_description' => 'nullable|string',
        ]);

        $floor = Floor::findOrFail($id);
        $floor->update($validatedData);

        return redirect()->route('floors.index')
            ->with('success', 'Floor updated successfully.');
    }

    public function destroy($id)
    {
        $floor = Floor::findOrFail($id);
        $floor->delete();

        return redirect()->route('floors.index')
            ->with('success', 'Floor deleted successfully.');
    }
}

