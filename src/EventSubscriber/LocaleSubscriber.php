<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{

    private $defaultLocale;

    public function __construct($defaultLocale='en')
    {
        $this->defaultLocale = $defaultLocale;
    }
    public function onKernelRequest(RequestEvent $event)
    {
        $request =$event->getRequest();
        if(!$request->hasSession())
        {
            return;
        }
        if ($locale = $request->query->get('_locale'))
        {
            $request->setLocale($locale);
        }else{
            $request->setLocale($request->getSession()->get('_locale',$this->defaultLocale));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            // On doit définir une priorité élevée
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}


