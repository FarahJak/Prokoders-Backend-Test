<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\SubTask\SubtaskIndexResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'subtasks'    => SubtaskIndexResource::collection($this->whenLoaded('subtasks')),
            'created_at'  => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
