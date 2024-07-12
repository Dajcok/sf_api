<?php

namespace app\Http\Controllers\CRUD;

use App\Contracts\Repositories\TableRepositoryContract;
use App\Http\Controllers\Abstract\CRUDController;
use App\Http\Resources\TableResource;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Models\Table;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TableController extends CRUDController
{
    public function __construct(TableRepositoryContract $repository, TableResource $resource)
    {
        parent::__construct($repository, $resource, Table::class);
    }

    /**
     * Display a listing of the resource.
     *
     * {@inheritdoc}
     *
     * @OA\Get(
     *     tags={"Table"},
     *     path="/api/tables",
     *     @OA\Response(
     *         response="200",
     *         description="Tables retrieved successfully",
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
     *                                     property="tables",
     *                                     type="array",
     *                                     @OA\Items(ref="#/components/schemas/Table")
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
     *     tags={"Table"},
     *     path="/api/tables/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the table to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Table retrieved successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/Table")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Table not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function show(int $id, Request $request): JsonResponse
    {
        return parent::show($id, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     tags={"Table"},
     *     path="/api/tables",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreTableRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Table created successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Table"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function store(StoreTableRequest $request): JsonResponse
    {
        return $this->performStore($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     tags={"Table"},
     *     path="/api/tables/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the table to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTableRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Table updated successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Table"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Table not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateTableRequest $request): JsonResponse
    {
        return $this->performUpdate($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     tags={"Table"},
     *     path="/api/tables/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the table to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Table deleted successfully"
     *     ),
     *     @OA\Response(response="404", description="Table not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::destroy($id);
    }
}
