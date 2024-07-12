<?php

namespace App\Http\Controllers\Abstract;

use App\Contracts\Repositories\RepositoryContract;
use App\Http\Controllers\Utils\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
    use AuthorizesRequests;

    public function __construct(
        protected readonly RepositoryContract $repository,
        protected readonly JsonResource $resource,
        protected readonly string $modelName
    ) {
        parent::__construct();
    }

    /**
     * @throws AuthorizationException
     */
    protected function performStore(FormRequest $request): JsonResponse
    {
        $this->authorize('create', $this->modelName);

        /** @var TStoreRequest $request */
        $model = $this->repository->create($request->validated());
        $resource = new $this->resource($model);
        return Response::send(SymfonyResponse::HTTP_CREATED, 'Resource created successfully.', $resource->toArray($request));
    }

    /**
     * @throws AuthorizationException
     */
    protected function performUpdate(int $id, FormRequest $request): JsonResponse
    {
        $model = $this->repository->find($id);
        $this->authorize('update', $model);

        /** @var TUpdateRequest $request */
        $data = new $this->resource($this->repository->update($id, $request->validated()));
        return Response::send(SymfonyResponse::HTTP_OK, 'Resource updated successfully.', $data->toArray($request));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $this->authorize('viewAny', $this->modelName);

            $items = $this->repository->all();
        } catch (AuthorizationException) {
            $items = $this->repository->all()->filter(function ($item) {
                return auth()->user()->can('view', $item);
            });
        }

        $data = new BaseCollection($items);
        return Response::send(SymfonyResponse::HTTP_OK, 'Resources retrieved successfully.', $data->toArray($request));
    }

    /**
     * Display the specified resource.
     *
     * @param int     $id
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(int $id, Request $request): JsonResponse
    {
        $model = $this->repository->find($id);
        $this->authorize('view', $model);

        $data = new $this->resource($model);
        return Response::send(SymfonyResponse::HTTP_OK, 'Resource retrieved successfully.', $data->toArray($request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $model = $this->repository->find($id);
        $this->authorize('delete', $model);

        $this->repository->delete($id);
        return Response::send(SymfonyResponse::HTTP_NO_CONTENT, 'Resource deleted successfully.');
    }
}
