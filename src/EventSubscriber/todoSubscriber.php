<?php

namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;

class todoSubscriber implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist
        ];
    }

    public function postPersist()
    {
        dump('Hello from event subscriber dude!');
    }
}