<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubTask\StoreSubtaskRequest;
use App\Http\Requests\SubTask\UpdateSubtaskRequest;
use App\Http\Resources\SubTask\SubtaskIndexResource;
use App\Http\Resources\SubTask\SubtaskShowResource;
use App\Services\SubTaskService;
use App\Traits\JsonResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SubTaskController extends Controller
{
    use JsonResponser;

    public function __construct(protected SubTaskService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = $this->service->indexHandler(request()->all());
        return $this->success(SubtaskIndexResource::collection($data), 'All Data Retrieved successfully', Response::HTTP_OK, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubtaskRequest $request): JsonResponse
    {
        $this->service->storeHandler($request->validated());
        return $this->success(null, 'Data Storeded Successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = $this->service->showHandler($id);
        return $this->success(new SubtaskShowResource($data), 'Data Retrieved successfully', Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubtaskRequest $request, string $id): JsonResponse
    {
        $this->service->updateHandler($request->validated(), $id);
        return $this->success(null, 'Data Updated Successfully', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->service->destroyHandler($id);
        return $this->success(null, 'Data Deleted Successfully', Response::HTTP_OK);
    }
}
