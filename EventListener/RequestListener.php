<?php

namespace Cedriclombardot\PinbaBundle\EventListener;

use Cedriclombardot\PinbaBundle\Pinba\Context;
use Cedriclombardot\PinbaBundle\Pinba\TimerManager;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class RequestListener
{
    protected $context;

    public function __construct(Context $context)
    {
        $this->context = $context;

        // Force Init TimerManager
        TimerManager::createInstance($context);
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }

        $this->context->startTimerForRequest($event->getRequest());
    }
}
