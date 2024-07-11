<?php

namespace App\Http\Controllers\Abstract;

use app\Contracts\Repositories\RepositoryContract;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Response;
use App\Http\Requests\Request;
use App\Http\Resources\BaseCollection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CRUDController extends Controller
{
    public function __construct(protected RepositoryContract $repository, protected JsonResource $resource)
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = new BaseCollection($this->repository->all());
        return Response::send(SymfonyResponse::HTTP_OK, 'Orders retrieved successfully.', $data->toArray($request));
    }

    /**
     * Store a newly created resource in storage.
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
     */
    public function update(int $id, FormRequest $request): JsonResponse
    {
        $order = new $this->resource($this->repository->update($id, $request->validated()));
        return Response::send(SymfonyResponse::HTTP_OK, 'Order updated successfully.', $order->toArray($request));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->repository->delete($id);
        return Response::send(SymfonyResponse::HTTP_NO_CONTENT, 'Order deleted successfully.');
    }
}
