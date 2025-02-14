<?php

namespace Tests\Feature;

use App\Models\SubTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TaskStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_status_updates_to_completed_when_all_subtasks_are_completed()
    {
        $user = User::create([
            'name'     => 'testUser',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password')
        ]);

        $task = Task::create([
            'title'       => 'Main Task',
            'description' => 'Test Test Test',
            'status'      => 'pending',
            'user_id'     => $user->id
        ]);

        $subtask1 = SubTask::create([
            'task_id'     => $task->id,
            'title'       => 'Subtask 1',
            'description' => 'Test Test Test',
            'status'      => 'completed'
        ]);

        $subtask2 = SubTask::create([
            'task_id'     => $task->id,
            'title'       => 'Subtask 2',
            'description' => 'Test Test Test',
            'status'      => 'completed'
        ]);

        $listener = app(\App\Listeners\UpdateParentTaskStatus::class);

        $listener->handle(new \App\Events\SubtaskUpdated($subtask1));
        $listener->handle(new \App\Events\SubtaskUpdated($subtask2));

        $this->assertEquals('completed', $task->fresh()->status);
    }

    public function test_task_status_updates_to_in_progress_when_some_subtasks_are_in_progress()
    {
        $user = User::create([
            'name'     => 'testUser',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password')
        ]);

        $task = Task::create([
            'title'       => 'Main Task',
            'description' => 'Test Test Test',
            'status'      => 'pending',
            'user_id'     => $user->id
        ]);

        $subtask1 = SubTask::create([
            'task_id'     => $task->id,
            'title'       => 'Subtask 1',
            'description' => 'Test Test Test',
            'status'      => 'pending'
        ]);

        $subtask2 = SubTask::create([
            'task_id'     => $task->id,
            'title'       => 'Subtask 2',
            'description' => 'Test Test Test',
            'status'      => 'in_progress'
        ]);

        $listener = app(\App\Listeners\UpdateParentTaskStatus::class);

        $listener->handle(new \App\Events\SubtaskUpdated($subtask1));
        $listener->handle(new \App\Events\SubtaskUpdated($subtask2));

        $this->assertEquals('in_progress', $task->fresh()->status);
    }

    public function test_task_status_remains_pending_when_no_subtasks_exist()
    {
        $user = User::create([
            'name'     => 'testUser',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password')
        ]);

        $task = Task::create([
            'title'       => 'Main Task',
            'description' => 'Test Test Test',
            'status'      => 'pending',
            'user_id'     => $user->id
        ]);

        $listener = app(\App\Listeners\UpdateParentTaskStatus::class);

        $this->assertEquals('pending', $task->fresh()->status);
    }
}
