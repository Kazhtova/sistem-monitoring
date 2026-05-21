<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComputerView implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public int $id_komputer;
    public int $id_laboratorium; 
    
    public function __construct(int $id_komputer, int $id_laboratorium)
    {
        $this->id_komputer = $id_komputer;
        $this->id_laboratorium = $id_laboratorium; 
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('laboratorium.' . $this->id_laboratorium),
        ];
    }

    public function broadcastAs(){
        return 'ComputerAccepted';   
    }
}