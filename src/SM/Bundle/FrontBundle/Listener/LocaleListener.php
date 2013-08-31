<?php
namespace SM\Bundle\FrontBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * locale listener class
 */
class LocaleListener implements EventSubscriberInterface
{
   private $defaultLocale;

   /**
    * constructor
    *
    * @param type $defaultLocale
    */
   public function __construct($defaultLocale = 'vi')
   {
       $this->defaultLocale = $defaultLocale;
   }

   /**
    * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
    *
    * @return type
    */
   public function onKernelRequest(GetResponseEvent $event)
   {
       $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {

            return;
        }

        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            $request->setLocale(
                $request->getSession()->get('_locale', $this->defaultLocale)
            );
        }
   }

   /**
    * @return type
    */
   public static function getSubscribedEvents()
   {
       return array(
           // must be registered before the default Locale listener
           KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
       );
   }
}