<?php

namespace Bytesoft\Base\Listeners;

use Bytesoft\Base\Events\UpdatedContentEvent;
use Exception;

class UpdatedContentListener
{

    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     * @author Bytesoft
     */
    public function handle(UpdatedContentEvent $event)
    {
        try {
            do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, $event->screen, $event->request, $event->data);

            cache()->forget('public.sitemap');
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
