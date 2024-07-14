<?php

namespace app\Http\Controllers\CRUD;

use App\Contracts\Repositories\OrderRepositoryContract;
use App\Http\Controllers\Abstract\ResourceController;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Order",
 *     description="Endpoints for order management"
 * )
 *
 * @extends ResourceController<StoreOrderRequest, UpdateOrderRequest>
 */
class OrderController extends ResourceController
{
    public function __construct(OrderRepositoryContract $repository, OrderResource $resource)
    {
        parent::__construct($repository, $resource, Order::class);
    }

    /**
     * Display a listing of the resource.
     *
     * {@inheritdoc}
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
     *                     @OA\Property(
     *                         property="data",
     *                         type="object",
     *                         allOf={
     *                             @OA\Schema(ref="#/components/schemas/BaseCollection"),
     *                             @OA\Schema(
     *                                 @OA\Property(
     *                                     property="items",
     *                                     type="array",
     *                                     @OA\Items(ref="#/components/schemas/Order")
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
     * @param StoreOrderRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     tags={"Order"},
     *     path="/api/orders",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreOrderRequest")
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
     * @throws AuthorizationException
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        return $this->performStore($request);
    }

    /**
     * Display the specified resource.
     *
     * {@inheritdoc}
     *
     * @OA\Get(
     *     tags={"Order"},
     *     path="/api/orders/{id}",
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
     * @param int                $id
     * @param UpdateOrderRequest $request
     * @return JsonResponse
     *
     * @OA\Put(
     *     tags={"Order"},
     *     path="/api/orders/{id}",
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
     *         @OA\JsonContent(ref="#/components/schemas/UpdateOrderRequest")
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
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateOrderRequest $request): JsonResponse
    {
        return $this->performUpdate($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * {@inheritdoc}
     *
     * @OA\Delete(
     *     tags={"Order"},
     *     path="/api/orders/{id}",
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
