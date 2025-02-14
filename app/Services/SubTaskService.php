<?php

namespace App\Services;

use App\Events\SubtaskUpdated;
use App\Models\SubTask;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubTaskService
{
    protected SubTask $model;

    public function __construct(SubTask $model)
    {
        $this->model = $model;
    }
    public function indexHandler()
    {
        $results = $this->model::query()->with(['task'])
            ->when(request('title'), function ($query, $title) {
                return $query->where('title', 'like', "%" . $title  . "%");
            })
            ->when(request('task_id'), function ($query, $task_id) {
                return $query->where('task_id',  $task_id);
            })
            ->when(request('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(request('per_page') ?? 10);
        return $results;
    }

    public function showHandler($id)
    {
        $result = $this->model::find($id);

        if (!$result)
            throw new NotFoundHttpException('Not Found');

        return $result;
    }

    public function storeHandler(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->model::create($data);

            DB::commit();
            return true;
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return false;
        }
    }

    public function updateHandler($data, $id)
    {
        DB::beginTransaction();
        try {
            $subtask = $this->model::find($id);

            $subtask->update($data);

            SubtaskUpdated::dispatch($subtask);

            DB::commit();
            return true;
        } catch (Exception) {
            DB::rollBack();
            return false;
        }
    }

    public function destroyHandler($id)
    {
        $result = $this->model::find($id);

        if (!$result)
            throw new NotFoundHttpException('Not Found');

        return $result->delete();
    }
}
