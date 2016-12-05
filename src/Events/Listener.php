<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 12:02 PM
 */

namespace Commander\Events;


use Commander\Commands\CommandBus;

abstract class Listener implements ListenerInterface
{
    protected $commandBus;

    /**
     * Listener constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    abstract public function receive(Event $event);
}