<?php

namespace App\Events;

use App\Models\Transformer;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransformerRunCompleteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Transformer $transformer)
    {
        //
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->transformer->id,
            'order' => $this->transformer->order,
            'type' => $this->transformer->type->value,
            'project_id' => $this->transformer->project_id,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('projects.'.$this->transformer->project_id),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'transformersRun';
    }
}
