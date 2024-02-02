<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(private Task $task)
    {
        $this->task->created_at = $this->task->created_at->diffForHumans();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->task->user_id . '.tasks'),
        ];
    }
    /**
     * The event's broadcast name.
     */
    public function broadcastWith(): array
    {
        return [
            'task' =>[
                'id' => $this->task->id,
                'title' => $this->task->title,
                'desc'   => $this->task->desc,
                'created_at' => $this->task->created_at->diffForHumans(),
                'status_label' => $this->task->status_label,
                'status'    => $this->task->status,
                'translated_status' => $this->task->translated_status,
            ],
            'message' => 'New task created'
        ];
    }
}
