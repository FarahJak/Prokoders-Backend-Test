<?php

namespace App\Services;

use App\Models\Task;
use App\Notifications\AllSubtasksCompleted;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    protected Task $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }
    public function indexHandler()
    {
        $tasks = Cache::remember('task_list', 5 * 60, function () {
            $results = $this->model::query()->with(['user'])
                ->when(request('title'), function ($query, $title) {
                    return $query->where('title', 'like', "%" . $title  . "%");
                })
                ->when(request('status'), function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(request('per_page') ?? 10);
            return $results;
        });

        return $tasks;
    }

    public function showHandler($id)
    {
        $result = $this->model::with(['subtasks'])->find($id);

        if (!$result)
            throw new NotFoundHttpException('Not Found');

        return $result;
    }

    public function storeHandler(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->model::create(array_merge($data, ['user_id' => auth('users')->user()->id]));

            DB::commit();
            return $result;
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
            $result = $this->model::find($id);

            $result->update($data);

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

    ##____________________________________________##
    public function updateParentTaskStatus(Task $task)
    {
        $subtasks = $task->subtasks()->select('status')->get();

        if ($subtasks->isEmpty()) {
            $newStatus = 'pending';
        } elseif ($subtasks->every(fn($s) => $s->status === 'completed')) {
            $newStatus = 'completed';

            Notification::send($task->user, new AllSubtasksCompleted($task));
        } elseif ($subtasks->contains(fn($s) => in_array($s->status, ['in_progress', 'pending']))) {
            $newStatus = 'in_progress';
        } else {
            $newStatus = $task->status;
        }

        if ($task->status !== $newStatus) {
            $task->update(['status' => $newStatus]);
        }
    }
}
