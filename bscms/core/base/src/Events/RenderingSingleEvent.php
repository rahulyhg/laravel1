<?php

namespace Bytesoft\Base\Events;

use Bytesoft\Slug\Models\Slug;
use Illuminate\Queue\SerializesModels;

class RenderingSingleEvent extends Event
{
    use SerializesModels;

    /**
     * @var Slug
     */
    public $slug;

    /**
     * RenderingSingleEvent constructor.
     * @param Slug $slug
     */
    public function __construct(Slug $slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     * @author Bytesoft
     */
    public function broadcastOn()
    {
        return [];
    }
}
