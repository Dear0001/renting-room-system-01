<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;



/**
 * @OA\Info(
 *     title="Your API Title",
 *     version="1.0.0",
 *     description="Your API Description",
 *     @OA\Contact(
 *         email="your-email@example.com",
 *         name="Your Name"
 *     ),
 *     @OA\License(
 *         name="MIT License",
 *         url="https://opensource.org/licenses/MIT"
 *     )
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
        $rooms = Room::with('floors', 'category')->get();
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
                if ($image !== null && $image->isValid()) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $uploadPath = public_path('img/');
                    $image->move($uploadPath, $filename);
                    $validatedData['image'] = 'img/' . $filename;
                } else {
                    return response()->json(['message' => 'Invalid file uploaded'], 400);
                }
            }

            $room = Room::create($validatedData);
            $room->load('floors', 'category');

            return response()->json([
                'message' => 'Room created successfully',
                'payload' => [
                    'room' => $room,
                    'image_url' => isset($validatedData['image']) ? url($validatedData['image']) : null,
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to create room: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get all rooms by category name.
     *
     * @OA\Get(
     *      path="/api/rooms/category/{name}",
     *      tags={"Rooms"},
     *      summary="Get rooms by category name",
     *      @OA\Parameter(
     *          name="name",
     *          in="path",
     *          required=true,
     *          description="Name of the category",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of rooms by category name",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Room")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No rooms found for the specified category",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public
    function getAllRoomByCategoryName($name)
    {
        try {
            $rooms = Room::with('floors', 'category')
                ->whereHas('category', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                })->get();

            return response()->json([
                'message' => 'Rooms retrieved successfully',
                'payload' => $rooms
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to retrieve rooms: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/rooms/{id}",
     *      tags={"Rooms"},
     *      summary="Get room details",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Room ID",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Room details",
     *          @OA\JsonContent(ref="#/components/schemas/Room")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Room not found",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public
    function show($id)
    {
        try {
            $room = Room::with('floors', 'category')->findOrFail($id);
            return response()->json([
                'message' => 'Room retrieved successfully',
                'payload' => $room
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Room not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to retrieve room: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Schema(
     *     schema="RoomRequest",
     *     type="object",
     *     required={"room_number", "floor_id", "category_id", "is_available"},
     *     @OA\Property(
     *         property="room_number",
     *         type="string",
     *         description="Room number"
     *     ),
     *     @OA\Property(
     *         property="room_description",
     *         type="string",
     *         nullable=true,
     *         description="Room description"
     *     ),
     *     @OA\Property(
     *         property="floor_id",
     *         type="integer",
     *         description="Floor ID"
     *     ),
     *     @OA\Property(
     *         property="category_id",
     *         type="integer",
     *         description="Category ID"
     *     ),
     *     @OA\Property(
     *         property="is_available",
     *         type="boolean",
     *         description="Availability status"
     *     ),
     *     @OA\Property(
     *         property="image",
     *         type="string",
     *         format="binary",
     *         nullable=true,
     *         description="Room image"
     *     )
     * )
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
                $image = $request->file('image');
                if ($image !== null && $image->isValid()) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $uploadPath = public_path('img/');
                    $image->move($uploadPath, $filename);
                    $validatedData['image'] = 'img/' . $filename;
                } else {
                    return response()->json(['message' => 'Invalid file uploaded'], 400);
                }
            }

            // Update the room with validated data
            $room->update($validatedData);

            // Reload relationships for the updated room
            $room->load('floors', 'category');

            // Log the request data for debugging
            Log::info('Request Data', $request->all());

            // Respond with success message and updated room data
            return response()->json([
                'message' => 'Room updated successfully',
                'payload' => [
                    'room' => $room,
                    'image_url' => isset($validatedData['image']) ? url($validatedData['image']) : null,
                ]
            ], 201);

        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Room not found.'], 404);
        } catch (ValidationException $exception) {
            return response()->json(['message' => $exception->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to update room: ' . $e->getMessage()], 500);
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
     *          description="Room ID",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Deleted the room",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Room not found",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public
    function destroy($id)
    {
        try {
            $room = Room::findOrFail($id);
            // Delete the image file if it exists
            if ($room->image) {
                unlink(public_path($room->image));
            }
            $room->delete();

            return response()->json([
                'message' => 'Room deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Room not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to delete room: ' . $e->getMessage()], 500);
        }
    }
}
