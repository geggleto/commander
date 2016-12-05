<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-02
 * Time: 11:48 AM
 */

namespace Commander\Responses;


use Commander\Responses\CommandResponseInterface;

abstract class CommandResponse implements CommandResponseInterface
{
    protected $payload;

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }


    abstract public function __toString();
}