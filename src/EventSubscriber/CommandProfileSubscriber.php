<?php
/**
 * Created by PhpStorm.
 * User: anboo
 * Date: 02.03.19
 * Time: 10:29
 */

namespace Anboo\Profiler\Bundle\EventSubscriber;

use Anboo\Profiler\Prof;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CommandProfileSubscriber
 */
class CommandProfileSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string[]
     */
    private $ignoreCommandsRegex;

    /**
     * CommandProfileSubscriber constructor.
     * @param LoggerInterface $logger
     * @param string[]        $ignoreCommandsRegex
     */
    public function __construct(LoggerInterface $logger, array $ignoreCommandsRegex)
    {
        $this->logger = $logger;
        $this->ignoreCommandsRegex = $ignoreCommandsRegex;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::COMMAND => 'onStartCommand',
            ConsoleEvents::ERROR => 'onCommandError',
            ConsoleEvents::TERMINATE => 'onCommandTerminate',
        ];
    }

    /**
     * @param ConsoleCommandEvent $event
     */
    public function onStartCommand(ConsoleCommandEvent $event)
    {
        $name = $event->getCommand()->getName();
        if (!$this->isCommandSupported($name)) {
            return;
        }

        $this->logger->debug(sprintf('Start profiler span with name %s', $name));

        Prof::start($name);
    }

    /**
     * @param ConsoleErrorEvent $event
     */
    public function onCommandError(ConsoleErrorEvent $event)
    {
        $this->logger->debug(sprintf(
            'Skip span with name %s because command failed with exit code %d',
            $event->getCommand()->getName(),
            $event->getExitCode()
        ));
    }

    /**
     * @param ConsoleTerminateEvent $event
     */
    public function onCommandTerminate(ConsoleTerminateEvent $event)
    {
        $name = $event->getCommand()->getName();
        if (!$this->isCommandSupported($name)) {
            return;
        }

        $this->logger->debug(sprintf('End and flush profiler span with name %s', $name));

        Prof::end($name);
        Prof::flush();
    }

    /**
     * @param string $commandName
     * @return bool
     */
    private function isCommandSupported(string $commandName)
    {
        foreach ($this->ignoreCommandsRegex as $ignoreCommandsRegex) {
            $first = $ignoreCommandsRegex[0];
            $last = $ignoreCommandsRegex[strlen($ignoreCommandsRegex) - 1];

            if ($first !== '/') {
                $ignoreCommandsRegex = '/'.$ignoreCommandsRegex;
            }

            if ($last !== '/') {
                $ignoreCommandsRegex = $ignoreCommandsRegex.'/';
            }

            if (preg_match($ignoreCommandsRegex, $commandName)) {
                return false;
            }
        }

        return true;
    }
}