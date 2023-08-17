<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SuperAdminOwnerChat implements ShouldBroadCast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    
    private $message;
    private $super_admin_id;
    private $owner_id;
    private $type;
    public function __construct($message, $super_admin_id, $owner_id, $type)
    {
        
        $this->message = $message;
        $this->super_admin_id = $super_admin_id;
        $this->owner_id = $owner_id;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('private-super-admin-owner-chat.'. $this->super_admin_id . '.' . $this->owner_id);
    }
    

    
}
