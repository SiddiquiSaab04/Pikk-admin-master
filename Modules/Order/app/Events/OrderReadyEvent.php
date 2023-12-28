<?php

namespace Modules\Order\app\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class OrderReadyEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $order;
    public $branch;
    /**
     * Create a new event instance.
     */
    public function __construct($order, $branch)
    {
        $this->order = $order;
        $this->branch = $branch;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn()
    {
        return new Channel("ready-order-channel.".$this->branch);
    }
}
