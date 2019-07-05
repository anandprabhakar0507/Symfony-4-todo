<?php


namespace App\customEvents;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TodoCustomSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [

            TodoEvent::NAME => 'todoOpened'
        ];
    }

    public function todoOpened(TodoEvent $todoEvent)
    {
       echo 'HELLO FROM THE SUBSCRIBER:::: '  . $todoEvent->getTodo()->getDescription();
    }
}