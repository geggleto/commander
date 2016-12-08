<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 11:08 AM
 */

namespace Commander\Events;


use Interop\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class EventBus
{
    /** @var array  */
    protected $list;

    /** @var LoggerInterface */
    protected $logger;


    /**
     * EventBus constructor.
     */
    public function __construct()
    {
        $this->list = [];
    }

    /**
     * @param string $key
     * @param callable $listener
     */
    public function addListener($key, callable $listener) {
        if (!isset($this->list[$key])) {
            $this->list[$key] = [];
        }

        $this->list[$key][] = $listener;
    }

    /**
     * @param Event $event
     */
    public function notify(Event $event) {
        $key = $event->getKey();

        /** @var $listener array */
        foreach ($this->list[$key] as $listener) {
            if ($this->logger) {
                $this->logger->info("Calling Event Listener" . join(':', $listener) ." for event key" . $key);
            }
            call_user_func($listener, $event);
        }
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }


}