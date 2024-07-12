<?php

namespace App\Http\Controllers\Abstract;

use App\Contracts\Repositories\RepositoryContract;
use App\Http\Controllers\Utils\Response;
use Illuminate\Http\Request;
use App\Http\Resources\BaseCollection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class CRUDController
 * @package App\Http\Controllers\Abstract
 * @template TStoreRequest of FormRequest
 * @template TUpdateRequest of FormRequest
 */
abstract class CRUDController extends Controller
{
    public function __construct(
        protected readonly RepositoryContract $repository,
        protected readonly JsonResource $resource
    ) {
        parent::__construct();
    }

    protected function performStore(FormRequest $request): JsonResponse
    {
        /** @var TStoreRequest $request */
        $model = $this->repository->create($request->validated());
        $resource = new $this->resource($model);
        return Response::send(SymfonyResponse::HTTP_CREATED, 'Resource created successfully.', $resource->toArray($request));
    }

    protected function performUpdate(int $id, FormRequest $request): JsonResponse
    {
        /** @var TUpdateRequest $request */
        $model = $this->repository->update($id, $request->validated());
        $resource = new $this->resource($model);
        return Response::send(SymfonyResponse::HTTP_OK, 'Resource updated successfully.', $resource->toArray($request));
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
