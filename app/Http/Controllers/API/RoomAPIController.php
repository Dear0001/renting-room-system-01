<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="Room API",
 *      version="1.0.0",
 *      description="API endpoints for managing rooms.",
 *      @OA\Contact(
 *          email="support@example.com",
 *          name="Support Team"
 *      )
 * )
 */
class RoomAPIController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/api/rooms",
     *      tags={"Rooms"},
     *      summary="Get all rooms",
     *      @OA\Response(
     *          response=200,
     *          description="List of rooms",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function index()
    {
        $rooms = Room::all();
        return response()->json(['rooms' => $rooms], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/api/rooms",
     *      tags={"Rooms"},
     *      summary="Create a new room",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created a new room",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|unique:rooms',
            'room_description' => 'nullable',
            'floor_id' => 'required|exists:floors,id',
            'category_id' => 'required|exists:room_categories,id',
        ]);

        $room = Room::create($validatedData);

        return response()->json(['room' => $room], 201);
    }

    /**
     * @OA\Get(
     *      path="/api/api/rooms/{id}",
     *      tags={"Rooms"},
     *      summary="Get a specific room",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the room",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Room details",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return response()->json(['room' => $room], 200);
    }

    /**
     * @OA\Put(
     *      path="/api/api/rooms/{id}",
     *      tags={"Rooms"},
     *      summary="Update a room",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the room",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(),
     *      @OA\Response(
     *          response=200,
     *          description="Updated room",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $id,
            'room_description' => 'nullable',
            'floor_id' => 'required|exists:floors,id',
            'category_id' => 'required|exists:room_categories,id',
        ]);

        $room = Room::findOrFail($id);
        $room->update($validatedData);

        return response()->json(['room' => $room], 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/api/rooms/{id}",
     *      tags={"Rooms"},
     *      summary="Delete a room",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the room",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Room deleted"
     *      )
     * )
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(null, 204);
    }
}
