<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserIndexResource;
use App\Services\UserService;
use App\Traits\JsonResponser;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use JsonResponser;

    public function __construct(protected UserService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = $this->service->indexHandler();
        return $this->success(UserIndexResource::collection($users), 'All Data Retrieved successfully', Response::HTTP_OK, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->service->storeHandler($request->validated());
        return $this->success(null, 'Data Storeded Successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->service->showHandler($id);
        return $this->success(new UserIndexResource($user), 'Data Retrieved successfully', Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id): JsonResponse
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
