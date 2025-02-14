<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_task_and_add_subtasks()
    {
        $adminUser = User::factory()->create([
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($adminUser);

        $taskData = [
            'title'       => 'Main Task',
            'description' => 'Test Test Test Test Test',
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201);
        $taskId = $response->json('data.id');
        $this->assertDatabaseHas('tasks', ['id' => $taskId, 'title' => 'Main Task']);

        $subtasksData = [
            [
                'title'       => 'Subtask 1',
                'description' => 'Test Test Test Test Test',
                'task_id'     => $taskId,
            ],
            [
                'title'       => 'Subtask 2',
                'description' => 'Test Test Test Test Test',
                'task_id'     => $taskId,
            ],
        ];

        foreach ($subtasksData as $subtask) {
            $subtaskResponse = $this->postJson("/api/subtasks", $subtask);
            $subtaskResponse->assertStatus(201);
            $this->assertDatabaseHas('sub_tasks', ['title' => $subtask['title']]);
        }
    }
}
