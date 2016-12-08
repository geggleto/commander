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


    /**
     * Event constructor.
     * @param string $key
     * @param array $payload
     */
    protected function __construct($key = '', array $payload = [])
    {
        $this->key = $key;
        $this->payload = $payload;
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

}