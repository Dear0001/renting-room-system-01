<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Floor;
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
     * @OA\Get(
     *     path="/api/floors",
     *     tags={"Floors"},
     *     summary="Get all floors",
     *     description="Returns a list of all floors.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Floor")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $floors = Floor::all();
        return response()->json($floors);
    }

    /**
     * Store a newly created floor in storage.
     *
     * @OA\Post(
     *     path="/api/floors",
     *     tags={"Floors"},
     *     summary="Create a new floor",
     *     description="Creates a new floor with the provided data.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FloorRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Floor created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Floor")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data provided",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Failed to create floor")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
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

        return response()->json($floor, 201);
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
        $floor = Floor::findOrFail($id);

        return response()->json($floor);
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
        $validator = Validator::make($request->all(), [
            'floor_name' => 'required|string',
            'floor_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Failed to update floor', 'errors' => $validator->errors()], 400);
        }

        $floor = Floor::findOrFail($id);
        $floor->update([
            'floor_name' => $request->floor_name,
            'floor_description' => $request->floor_description,
        ]);

        return response()->json($floor);
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
        $floor = Floor::findOrFail($id);
        $floor->delete();

        return response()->json(["msg" => "Floor deleted successfully"]);
    }
}
