<?php

namespace app\Http\Controllers\CRUD;

use App\Http\Controllers\Abstract\ResourceController;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Repositories\ItemRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Item",
 *     description="Endpoints for item management"
 * )
 */
class ItemController extends ResourceController
{
    public function __construct(ItemRepository $repository, ItemResource $resource, ItemCollection $collection)
    {
        parent::__construct($repository, $resource, $collection, Item::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     tags={"Item"},
     *     path="/api/items",
     *     @OA\Response(
     *         response="200",
     *         description="Items retrieved successfully",
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
     *                                     property="items",
     *                                     type="array",
     *                                     @OA\Items(ref="#/components/schemas/Item")
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
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     tags={"Item"},
     *     path="/api/items",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreItemRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Item created successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Item"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function store(StoreItemRequest $request): JsonResponse
    {
        return $this->performStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     tags={"Item"},
     *     path="/api/items/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the item to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Item retrieved successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Item"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Item not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function show(int $id, Request $request): JsonResponse
    {
        return parent::show($id, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     tags={"Item"},
     *     path="/api/items/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the item to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateItemRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Item updated successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Item"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Item not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateItemRequest $request): JsonResponse
    {
        return $this->performUpdate($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     tags={"Item"},
     *     path="/api/items/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the item to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Item deleted successfully"
     *     ),
     *     @OA\Response(response="404", description="Item not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::destroy($id);
    }
}
