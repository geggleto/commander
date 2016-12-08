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
use Interop\Container\ContainerInterface;

abstract class Handler implements HandlerInterface
{
    /** @var EventBus  */
    protected $eventBus;

    /** @var CommandBus  */
    protected $commandBus;

    /** @var ContainerInterface */
    protected $container;

    /**
     * Handler constructor.
     *
     * @param EventBus $eventBus
     * @param CommandBus $commandBus
     */
    public function __construct(EventBus $eventBus, CommandBus $commandBus, ContainerInterface $container)
    {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
        $this->container = $container;
    }


    /**
     * @param CommandInterface $command
     */
    abstract public function handle(CommandInterface $command);
}