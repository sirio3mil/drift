<?php

namespace App\Domain\EventSubscriber;

use App\Domain\Event\UserWasPut;
use Drift\HttpKernel\Event\DomainEventEnvelope;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PrintUserOnPut implements EventSubscriberInterface
{

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            UserWasPut::class => 'printUser'
        ];
    }

    /**
     * @param DomainEventEnvelope $envelope
     */
    public function printUser(DomainEventEnvelope $envelope){
        /** @var UserWasPut $event */
        $event = $envelope->getDomainEvent();
        echo "User {$event->getUser()->getId()} was put", PHP_EOL;
    }
}
