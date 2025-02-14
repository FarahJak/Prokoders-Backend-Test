<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Tasks\TaskIndexResource;
use App\Http\Resources\Tasks\TaskShowResource;
use App\Services\TaskService;
use App\Traits\JsonResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    use JsonResponser;

    public function __construct(protected TaskService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = $this->service->indexHandler(request()->all());
        return $this->success(TaskIndexResource::collection($data), 'All Data Retrieved successfully', Response::HTTP_OK, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $this->service->storeHandler($request->validated());
        return $this->success(new TaskIndexResource($data), 'Data Storeded Successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = $this->service->showHandler($id);
        return $this->success(new TaskShowResource($data), 'Data Retrieved successfully', Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id): JsonResponse
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
