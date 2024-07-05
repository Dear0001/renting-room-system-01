<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Floors",
 *     description="API Endpoints for managing floors"
 * )
 */

class FloorAPIController extends Controller
{
    /**
     * Display a listing of the floors.
     *
    /**
     * @OA\Get(
     *      path="/api/floor",
     *      tags={"Floors"},
     *      summary="Get all floors",
     *      @OA\Response(
     *          response=200,
     *          description="List of floor",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function index()
    {
        $floors = Floor::all();
        return response()->json([
            'message' => 'Floors retrieved successfully',
            'payload' => $floors
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/floors",
     *      tags={"Floors"},
     *      summary="Create a new floors",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RoomRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created a new floor",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'floor_name' => 'required|string',
                'floor_description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['msg' => 'Failed to create floor', 'errors' => $validator->errors()], 400);
            }

            $floor = Floor::create([
                'floor_name' => $request->floor_name,
                'floor_description' => $request->floor_description,
            ]);
            return response()->json([
                'message' => 'Floor created successfully',
                'payload' => $floor
            ], 201);
        }catch (Exception $e) {
            return response()->json(['msg' => 'Failed to create floor', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified floor.
     *
     * @OA\Get(
     *     path="/api/floors/{id}",
     *     tags={"Floors"},
     *     summary="Get a specific floor",
     *     description="Returns a specific floor based on ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Floor")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Floor not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Floor not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $floor = Floor::findOrFail($id);
            return response()->json([
                'message' => 'Floor retrieved successfully',
                'payload' => $floor
            ], 200);
        } catch (Exception $e) {
            return response()->json(['msg' => 'Floor not found', 'errors' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified floor in storage.
     *
     * @OA\Put(
     *     path="/api/floors/{id}",
     *     tags={"Floors"},
     *     summary="Update a floor",
     *     description="Updates a specific floor based on ID with the provided data.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FloorRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Floor updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Floor")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data provided",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Failed to update floor")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Floor not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Floor not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $floor = Floor::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'floor_name' => 'required|string',
                'floor_description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['msg' => 'Failed to update floor', 'errors' => $validator->errors()], 400);
            }

            $floor->update([
                'floor_name' => $request->floor_name,
                'floor_description' => $request->floor_description,
            ]);

            return response()->json([
                'message' => 'Floor updated successfully',
                'payload' => $floor
            ], 200);
        } catch (Exception $e) {
            return response()->json(['msg' => 'Floor not found', 'errors' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified floor from storage.
     *
     * @OA\Delete(
     *     path="/api/floors/{id}",
     *     tags={"Floors"},
     *     summary="Delete a floor",
     *     description="Deletes a specific floor based on ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Floor deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Floor deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Floor not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Floor not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $floor = Floor::findOrFail($id);
            $floor->delete();
            return response()->json(['msg' => 'Floor deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['msg' => 'Floor not found', 'errors' => $e->getMessage()], 404);
        }
    }
}
