<?php

namespace App\Http\Controllers\Abstract;

use App\Contracts\Repositories\RepositoryContract;
use App\Http\Controllers\Utils\Response;
use App\Http\Requests\Request;
use App\Http\Resources\BaseCollection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class CRUDController
 * @package App\Http\Controllers\Abstract
 * @template T of FormRequest
 */
abstract class CRUDController extends Controller
{
    public function __construct(
        protected readonly RepositoryContract $repository,
        protected readonly JsonResource $resource
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = new BaseCollection($this->repository->all());
        return Response::send(SymfonyResponse::HTTP_OK, 'Orders retrieved successfully.', $data->toArray($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $order = new $this->resource($this->repository->create($request->validated()));
        return Response::send(SymfonyResponse::HTTP_CREATED, 'Order created successfully.', $order->toArray($request));
    }

    /**
     * Display the specified resource.
     *
     * @param int     $id
     * @param Request $request
     * @return JsonResponse
     */
    public function show(int $id, Request $request): JsonResponse
    {
        $order = new $this->resource($this->repository->find($id));
        return Response::send(SymfonyResponse::HTTP_OK, 'Order retrieved successfully.', $order->toArray($request));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int         $id
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function update(int $id, FormRequest $request): JsonResponse
    {
        $order = new $this->resource($this->repository->update($id, $request->validated()));
        return Response::send(SymfonyResponse::HTTP_OK, 'Order updated successfully.', $order->toArray($request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->repository->delete($id);
        return Response::send(SymfonyResponse::HTTP_NO_CONTENT, 'Order deleted successfully.');
    }
}
