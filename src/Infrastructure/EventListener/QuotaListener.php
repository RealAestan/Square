<?php

namespace App\Infrastructure\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class QuotaListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$quotaLeft = $event->getRequest()->attributes->get('quota_left')) {
            return;
        }

        $response = $event->getResponse();
        $response->headers->set('x-quota-left', $quotaLeft);
    }
}
