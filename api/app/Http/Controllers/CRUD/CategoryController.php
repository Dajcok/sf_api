<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Abstract\ResourceController;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @OA\Tag(
 *     name="Category",
 *     description="Endpoints for category management"
 * )
 */
class CategoryController extends ResourceController
{
    public function __construct(CategoryRepository $repository, CategoryResource $resource, CategoryCollection $collection)
    {
        parent::__construct($repository, $resource, $collection, Category::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     tags={"Category"},
     *     path="/api/categories",
     *     @OA\Response(
     *         response="200",
     *         description="Categories retrieved successfully",
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
     *                                     property="categories",
     *                                     type="array",
     *                                     @OA\Items(ref="#/components/schemas/Category")
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
     *     tags={"Category"},
     *     path="/api/categories",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCategoryRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Category created successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Category"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        return $this->performStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     tags={"Category"},
     *     path="/api/categories/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Category retrieved successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Category"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Category not found"),
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
     *     tags={"Category"},
     *     path="/api/categories/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCategoryRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Category updated successfully",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/Category"
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(response="404", description="Category not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateCategoryRequest $request): JsonResponse
    {
        return $this->performUpdate($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     tags={"Category"},
     *     path="/api/categories/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Category deleted successfully"
     *     ),
     *     @OA\Response(response="404", description="Category not found"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        return parent::destroy($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthorizedResources(): LengthAwarePaginator|Collection
    {
        try {
            return parent::getAuthorizedResources();
        } catch (AuthorizationException) {
            return $this->repository->paginate($this->repository->withPermissions());
        }
    }
}
