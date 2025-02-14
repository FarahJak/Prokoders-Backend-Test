<?php

namespace Database\Seeders;

use App\Enums\TaskStatus;
use App\Models\SubTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SubTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subtasks = Collection::make([
            [
                'title'        => 'SubTask 1-1',
                'description'  => 'Test Test Test Test Test Test Test Test Test',
                'status'       => TaskStatus::PENDING->value,
                'task_id'      => 1,

            ],
            [
                'title'        => 'SubTask 1-2',
                'description'  => 'Test Test Test Test Test Test Test Test Test',
                'status'       => TaskStatus::PENDING->value,
                'task_id'      => 1,

            ],
            [
                'title'        => 'SubTask 1-3',
                'description'  => 'Test Test Test Test Test Test Test Test Test',
                'status'       => TaskStatus::PENDING->value,
                'task_id'      => 1,

            ],
            ##___________________________________________##
            [
                'title'        => 'SubTask 2-1',
                'description'  => 'Test Test Test Test Test Test Test Test Test',
                'status'       => TaskStatus::PENDING->value,
                'task_id'      => 2,

            ],
            [
                'title'        => 'SubTask 2-2',
                'description'  => 'Test Test Test Test Test Test Test Test Test',
                'status'       => TaskStatus::PENDING->value,
                'task_id'      => 2,

            ],
            [
                'title'        => 'SubTask 2-3',
                'description'  => 'Test Test Test Test Test Test Test Test Test',
                'status'       => TaskStatus::PENDING->value,
                'task_id'      => 2,

            ],
            ##___________________________________________##
            [
                'title'        => 'SubTask 3-1',
                'description'  => 'Test Test Test Test Test Test Test Test Test',
                'status'       => TaskStatus::PENDING->value,
                'task_id'      => 3,

            ],
            [
                'title'        => 'SubTask 3-2',
                'description'  => 'Test Test Test Test Test Test Test Test Test',
                'status'       => TaskStatus::PENDING->value,
                'task_id'      => 3,

            ],
            [
                'title'        => 'SubTask 3-3',
                'description'  => 'Test Test Test Test Test Test Test Test Test',
                'status'       => TaskStatus::PENDING->value,
                'task_id'      => 3,

            ],
        ]);

        $subtasks->each(function ($task) {
            SubTask::create($task);
        });
    }
}
