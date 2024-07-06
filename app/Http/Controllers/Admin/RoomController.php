<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Room;
use App\Models\Floor;
use App\Models\RoomCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rooms = Room::with('floor', 'category')->paginate(10);
            return view('rooms.index', compact('rooms'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to fetch rooms: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $floors = Floor::all();
            $categories = RoomCategory::all();
            return view('rooms.create', compact('floors', 'categories'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load creation form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'room_number' => 'required|unique:rooms',
                'price' => 'nullable|numeric|min:0',
                'room_description' => 'nullable',
                'floor_id' => 'required|exists:floors,id',
                'category_id' => 'required|exists:room_categories,id',
                'is_available' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $uploadPath = 'img/';
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path($uploadPath), $filename);
                $validatedData['image'] = $uploadPath . $filename;
            }

            $room = Room::create($validatedData);
            $room->load('floors', 'category');

            return redirect()->route('rooms.index')->with('success', 'Room created successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            return back()->with('error', 'Failed to create room: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $room = Room::with('floors', 'category')->findOrFail($id);
            return view('rooms.show', compact('room'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Room not found.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to fetch room details: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $room = Room::findOrFail($id);
            $floors = Floor::all();
            $categories = RoomCategory::all();
            return view('rooms.edit', compact('room', 'floors', 'categories'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Room not found.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'room_number' => 'required|unique:rooms',
                'price' => 'nullable|numeric|min:0',
                'room_description' => 'nullable',
                'floor_id' => 'required|exists:floors,id',
                'category_id' => 'required|exists:room_categories,id',
                'is_available' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
            ]);

            $room = Room::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($room->image) {
                    Storage::delete($room->image); // Delete old image using Storage facade
                }
                $image = $request->file('image');
                $uploadPath = 'img/';
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path($uploadPath), $filename);
                $validatedData['image'] = $uploadPath . $filename;
            }

            $room->update($validatedData);
            $room->load('floors', 'category');

            return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Room not found.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update room: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $room = Room::find($id);

            if (!$room) {
                return back()->with('error', 'Room not found.');
            }

            if ($room->image) {
                Storage::delete($room->image); // Delete associated image using Storage facade
            }

            $room->delete();

            return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete room: ' . $e->getMessage());
        }
    }
}
