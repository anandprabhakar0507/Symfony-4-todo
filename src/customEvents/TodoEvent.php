<?php

namespace App\customEvents;

use App\Entity\Todo;
use Symfony\Component\EventDispatcher\Event;

class TodoEvent extends Event
{

    public const NAME = 'todo.opened';
    protected $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function getTodo()
    {
        return $this->todo;
    }
}