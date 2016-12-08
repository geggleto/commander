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

        /** @var $listener callable */
        foreach ($this->list[$key] as $listener) {
            call_user_func($listener, $event);
        }
    }
}