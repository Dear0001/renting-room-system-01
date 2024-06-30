<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

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
     *      path="/api/rooms",
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
        $rooms = Room::with('floor', 'category')->get();
        return response()->json([
            'message' => 'Rooms retrieved successfully',
            'payload' => $rooms
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/rooms",
     *      tags={"Rooms"},
     *      summary="Create a new room",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RoomRequest")
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

        return response()->json([
            'message' => 'Room created successfully',
            'payload' => $room
        ], 201);
    }

    /**
     * @OA\Get(
     *      path="/api/rooms/{id}",
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
        try {
            $room = Room::with('floor', 'category')->findOrFail($id);
            return response()->json([
                'message' => 'Room retrieved successfully',
                'payload' => $room
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Room not found.'], 404);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/rooms/{id}",
     *      tags={"Rooms"},
     *      summary="Update a room",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the room",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RoomRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated room",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Room not found",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'room_number' => 'required|unique:rooms,room_number,' . $id,
                'room_description' => 'nullable',
                'floor_id' => 'required|exists:floors,id',
                'category_id' => 'required|exists:room_categories,id',
            ]);

            $room = Room::findOrFail($id);
            $room->update($validatedData);
            $room = Room::with('floor', 'category')->findOrFail($id); // to include related data

            return response()->json([
                'message' => 'Room updated successfully',
                'payload' => $room
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Room not found.'], 404);
        } catch (ValidationException $exception) {
            return response()->json(['message' => $exception->errors()], 422);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/rooms/{id}",
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
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Room not found",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function destroy($id)
    {
        try {
            $room = Room::findOrFail($id);
            $room->delete();

            return response()->json([
                'message' => 'Room deleted successfully'
            ], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Room not found.'], 404);
        }
    }

    /**
     * Get all available rooms.
     *
     * @OA\Get(
     *      path="/api/rooms/available",
     *      tags={"Rooms"},
     *      summary="Get available rooms",
     *      @OA\Response(
     *          response=200,
     *          description="List of available rooms",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Room")
     *          )
     *      )
     * )
     */
    public function getAvailableRooms()
    {
        try {
            $availableRooms = Room::where('is_available', true)
                ->with('floor', 'category')
                ->get();

            if ($availableRooms->isEmpty()) {
                return response()->json(['message' => 'No available rooms found.'], 404);
            }

            return response()->json([
                'message' => 'Available rooms retrieved successfully',
                'payload' => $availableRooms
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Get all unavailable rooms.
     *
     * @OA\Get(
     *      path="/api/rooms/unavailable",
     *      tags={"Rooms"},
     *      summary="Get unavailable rooms",
     *      @OA\Response(
     *          response=200,
     *          description="List of unavailable rooms",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Room")
     *          )
     *      )
     * )
     */
    public function getUnavailableRooms()
    {
        try {
            $unavailableRooms = Room::where('is_available', false)
                ->with('floor', 'category')
                ->get();

            if ($unavailableRooms->isEmpty()) {
                return response()->json(['message' => 'No unavailable rooms found.'], 404);
            }

            return response()->json([
                'message' => 'Unavailable rooms retrieved successfully',
                'payload' => $unavailableRooms
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }



    /**
     * @OA\Put(
     *      path="/api/rooms/{id}/book",
     *      tags={"Rooms"},
     *      summary="Mark a room as booked",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the room",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Room marked as booked",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Room not found",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function bookRoom($id)
    {
        try {
            $room = Room::findOrFail($id);
            $room->is_available = false;
            $room->save();
            $room = Room::with('floor', 'category')->findOrFail($id);


            return response()->json([
                'message' => 'Room booked successfully',
                'payload' => $room
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Room not found.'], 404);
        }
    }


    /**
     * @OA\Put(
     *      path="/api/rooms/{id}/free",
     *      tags={"Rooms"},
     *      summary="Mark a room as available",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the room",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Room marked as available",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Room not found",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function freeRoom($id)
    {
        try {
            $room = Room::findOrFail($id);
            $room->is_available = true;
            $room->save();
            $room = Room::with('floor', 'category')->findOrFail($id);

            return response()->json([
                'message' => 'Room marked as available successfully',
                'payload' => $room
            ], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Room not found.'], 404);
        }
    }
}
