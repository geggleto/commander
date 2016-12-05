<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 11:45 AM
 */

namespace Commander\Handlers;


use Commander\Commands\CommandBus;
use Commander\Commands\CommandInterface;
use Commander\Events\EventBus;
use Commander\Responses\CommandResponseInterface;

abstract class Handler implements HandlerInterface
{
    /** @var EventBus  */
    protected $eventBus;

    /**
     * Handler constructor.
     *
     * @param EventBus $eventBus
     */
    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @param CommandInterface $command
     *
     * @return CommandResponseInterface
     */
    abstract public function handle(CommandInterface $command);
}