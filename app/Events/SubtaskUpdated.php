<?php

namespace App\Events;

use App\Models\SubTask;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubtaskUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subtask;

    public function __construct(SubTask $subtask)
    {
        $this->subtask = $subtask;
    }
}
