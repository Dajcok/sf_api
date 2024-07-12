<?php

namespace app\Http\Controllers\CRUD;

use App\Contracts\Repositories\RestaurantRepositoryContract;
use App\Http\Controllers\Abstract\CRUDController;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends CRUDController
{
    public function __construct(RestaurantRepositoryContract $repository, JsonResource $resource)
    {
        parent::__construct($repository, $resource);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     tags={"Restaurant"},
     *     path="/api/restaurants",
     *     @OA\Response(
     *         response="200",
     *         description="Restaurants retrieved successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         type="object",
     *                         allOf={
     *                             @OA\Schema(ref="#/components/schemas/BaseCollection"),
     *                             @OA\Schema(
     *                                 @OA\Property(
     *                                     property="restaurants",
     *                                     type="array",
     *                                     @OA\Items(ref="#/components/schemas/Restaurant")
     *                                 )
     *                             )
     *                         }
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        return parent::index($request);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     tags={"Restaurant"},
     *     path="/api/restaurants/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the restaurant to retrieve",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Restaurant retrieved successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Restaurant"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Restaurant not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function show(int $id, Request $request): JsonResponse
    {
        return parent::show($id, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     tags={"Restaurant"},
     *     path="/api/restaurants",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreRestaurantRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Restaurant created successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Restaurant"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function store(StoreRestaurantRequest $request): JsonResponse
    {
        return $this->performStore($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     tags={"Restaurant"},
     *     path="/api/restaurants/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the restaurant to update",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateRestaurantRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Restaurant updated successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Restaurant"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Restaurant not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function update(int $id, UpdateRestaurantRequest $request): JsonResponse
    {
        return $this->performUpdate($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     tags={"Restaurant"},
     *     path="/api/restaurants/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the restaurant to delete",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Restaurant deleted successfully"
     *     ),
     *     @OA\Response(response="404", description="Restaurant not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::destroy($id);
    }
}
