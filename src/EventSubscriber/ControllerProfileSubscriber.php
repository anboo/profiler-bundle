<?php
/**
 * Created by PhpStorm.
 * User: anboo
 * Date: 02.03.19
 * Time: 10:30
 */

namespace Anboo\Profiler\Bundle\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ControllerProfileSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [];
    }
}