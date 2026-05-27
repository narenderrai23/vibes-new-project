<?php

namespace Modules\Post\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Post\Models\Post;

class PostUpdated
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public Post $post)
    {
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
