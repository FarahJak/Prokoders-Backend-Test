<?php

namespace App\Listeners;

use App\Events\SubtaskUpdated;
use App\Services\TaskService;

class UpdateParentTaskStatus
{
    protected TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function handle(SubtaskUpdated $event)
    {
        $subtask = $event->subtask;
        $this->service->updateParentTaskStatus($subtask->task);
    }
}
