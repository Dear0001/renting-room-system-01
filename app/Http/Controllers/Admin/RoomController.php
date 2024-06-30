<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Floor;
use App\Models\RoomCategory;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('floor', 'category')->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $floors = Floor::all();
        $categories = RoomCategory::all();
        return view('admin.rooms.create', compact('floors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms',
            'room_description' => 'nullable',
            'floor_id' => 'required|exists:floors,id',
            'category_id' => 'required|exists:room_categories,id',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')
                         ->with('success', 'Room created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $floors = Floor::all();
        $categories = RoomCategory::all();
        return view('admin.rooms.edit', compact('room', 'floors', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $id,
            'room_description' => 'nullable',
            'floor_id' => 'required|exists:floors,id',
            'category_id' => 'required|exists:room_categories,id',
        ]);

        $room = Room::findOrFail($id);
        $room->update($request->all());

        return redirect()->route('admin.rooms.index')
                         ->with('success', 'Room updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.rooms.index')
                         ->with('success', 'Room deleted successfully');
    }
}
