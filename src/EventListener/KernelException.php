<?php


namespace App\EventListener;


use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class KernelException
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
//        die('I am a listener');
    }
}