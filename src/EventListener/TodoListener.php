<?php


namespace App\EventListener;


use App\customEvents\TodoEvent;
use App\Entity\Todo;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TodoListener
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Todo)
            return;
    }

    public function todoOpened(TodoEvent $todoEvent)
    {
        echo  "<br>" . $todoEvent->getTodo()->getDescription() . "<br>";
    }


}