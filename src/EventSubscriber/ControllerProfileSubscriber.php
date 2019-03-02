<?php
/**
 * Created by PhpStorm.
 * User: anboo
 * Date: 02.03.19
 * Time: 10:30
 */

namespace Anboo\Profiler\Bundle\EventSubscriber;

use Anboo\Profiler\Prof;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ControllerProfileSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string[]
     */
    private $ignoreRoutesRegex;

    /**
     * ControllerProfileSubscriber constructor.
     * @param LoggerInterface $logger
     * @param string[] $ignoreRoutesRegex
     */
    public function __construct(LoggerInterface $logger, array $ignoreRoutesRegex)
    {
        $this->logger = $logger;
        $this->ignoreRoutesRegex = $ignoreRoutesRegex;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onRequest',
            KernelEvents::TERMINATE => 'onTerminate',
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onRequest(GetResponseEvent $event)
    {
        $name = $event->getRequest()->getRequestUri();
        if (!$this->isRouteSupported($name)) {
            return;
        }

        $this->logger->debug(sprintf('Start span %s', $name));

        Prof::start($name);
    }

    /**
     * @param PostResponseEvent $event
     */
    public function onTerminate(PostResponseEvent $event)
    {
        $name = $event->getRequest()->getRequestUri();
        if (!$this->isRouteSupported($name)) {
            return;
        }

        $this->logger->debug(sprintf('End and flush span %s', $name));

        Prof::end($name);
        Prof::flush();
    }

    /**
     * @param string $route
     * @return bool
     */
    private function isRouteSupported(string $route)
    {
        foreach ($this->ignoreRoutesRegex as $ignoreRoutesRegex) {
            $first = $ignoreRoutesRegex[0];
            $last = $ignoreRoutesRegex[strlen($ignoreRoutesRegex) - 1];

            if ($first !== '/') {
                $ignoreRoutesRegex = '/'.$ignoreRoutesRegex;
            }

            if ($last !== '/') {
                $ignoreRoutesRegex = $ignoreRoutesRegex.'/';
            }

            if (preg_match($ignoreRoutesRegex, $route)) {
                return false;
            }
        }

        return true;
    }
}