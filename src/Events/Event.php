<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 11:08 AM
 */

namespace Commander\Events;


abstract class Event
{
    /** @var string  */
    protected $key;

    /** @var array  */
    protected $payload;

    /** @var EventBus */
    protected $eventBus;

    /**
     * Event constructor.
     * @param string $key
     * @param array $payload
     */
    public function __construct($key = '', array $payload = [])
    {
        $this->key = $key;
        $this->payload = $payload;
        $this->eventBus = null;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return EventBus
     */
    public function getEventBus()
    {
        return $this->eventBus;
    }

    /**
     * @param EventBus $eventBus
     */
    public function setEventBus(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }



}