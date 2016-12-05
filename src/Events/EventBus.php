<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 11:08 AM
 */

namespace Commander\Events;


use Interop\Container\ContainerInterface;

class EventBus
{
    /** @var array  */
    protected $list;
    /**
     * EventBus constructor.
     */
    public function __construct()
    {
        $this->list = [];
    }

    /**
     * @param string $key
     * @param ListenerInterface $class
     */
    public function addListener($key, ListenerInterface $class) {
        if (!isset($this->list[$key])) {
            $this->list[$key] = [];
        }

        $this->list[$key][] = $class;
    }

    /**
     * @param Event $event
     */
    public function notify(Event $event) {
        $key = $event->getKey();
        $event->setEventBus($this);

        /** @var $listener ListenerInterface */
        foreach ($this->list[$key] as $listener) {
            $listener->receive($event);
        }
    }
}