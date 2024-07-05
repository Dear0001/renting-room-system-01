<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RoomCategory;
use Exception;
use Illuminate\Http\Request;


/**
 * @OA\Tag(name="Room Category", description="Room management endpoints")
 */
class RoomCategoryAPIController extends Controller
{
    /**
     * Display a listing of the room categories.
     *
     * @OA\Get(
     *     path="/api/room-categories",
     *     tags={"Room Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/RoomCategory")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $roomCategory = RoomCategory::all();
            return response()->json([
                'message' => 'Rooms retrieved successfully',
                'payload' => $roomCategory
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve rooms',
                'error' => $e->getMessage()
            ], 400);
        }

    }

    /**
     * Store a newly created room category in storage.
     *
     * @OA\Post(
     *     path="/api/room-categories",
     *     tags={"Room Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RoomCategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/RoomCategory")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Failed to create room category")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $roomCategory = RoomCategory::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json([
                'message' => 'Room category created successfully',
                'payload' => $roomCategory
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create room category',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified room category.
     *
     * @OA\Get(
     *     path="/api/room-categories/{id}",
     *     tags={"Room Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/RoomCategory")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Room category not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $roomCategory = RoomCategory::findOrFail($id);
            return response()->json($roomCategory);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Room category not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified room category in storage.
     *
     * @OA\Put(
     *     path="/api/room-categories/{id}",
     *     tags={"Room Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RoomCategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/RoomCategory")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Failed to update room category")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Room category not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $roomCategory = RoomCategory::findOrFail($id);
            $roomCategory->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json([
                'message' => 'Rooms Category update successfully',
                'payload' => $roomCategory
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update room category',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified room category from storage.
     *
     * @OA\Delete(
     *     path="/api/room-categories/{id}",
     *     tags={"Room Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Room category deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Room category not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $roomCategory = RoomCategory::findOrFail($id);
            $roomCategory->delete();

            return response()->json([
                'message' => 'Room category deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Room category not found',
                'error' => $e->getMessage()
            ], 404);

        }
    }
}
