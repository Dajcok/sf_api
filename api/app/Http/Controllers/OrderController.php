<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\OrderRepositoryContract;
use App\Http\Controllers\Abstract\CRUDController;
use App\Http\Requests\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends CRUDController
{
    public function __construct(OrderRepositoryContract $repository, OrderResource $resource)
    {
        parent::__construct($repository, $resource);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     tags={"Order"},
     *     path="/api/orders",
     *     @OA\Response(
     *         response="200",
     *         description="Orders retrieved successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/BaseCollection")
     *                 )
     *            }
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
     * @param StoreOrderRequest|FormRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     tags={"Order"},
     *     path="/api/orders",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="total", type="number"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Order created successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/Order")
     *                 )
     *            }
     *         )
     *     ),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function store(StoreOrderRequest|FormRequest $request): JsonResponse
    {
        return parent::store($request);
    }

    /**
     * Display the specified resource.
     *
     * {@inheritdoc}
     *
     * @OA\Get(
     *     tags={"Order"},
     *     path="/api/orders/{order}",
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Order retrieved successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/Order")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Order not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function show(int $id, Request $request): JsonResponse
    {
        return parent::show($id, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * {@inheritdoc}
     *
     * @OA\Put(
     *     tags={"Order"},
     *     path="/api/orders/{order}",
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="total", type="number"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Order updated successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(property="data", ref="#/components/schemas/Order")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Order not found"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function update(int $id, FormRequest $request): JsonResponse
    {
        return parent::update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * {@inheritdoc}
     *
     * @OA\Delete(
     *     tags={"Order"},
     *     path="/api/orders/{order}",
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Order deleted successfully"
     *     ),
     *     @OA\Response(response="404", description="Order not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::destroy($id);
    }
}
