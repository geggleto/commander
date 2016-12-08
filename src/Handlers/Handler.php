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
use Psr\Log\LoggerInterface;

abstract class Handler implements HandlerInterface
{
    /** @var EventBus  */
    protected $eventBus;

    /** @var CommandBus  */
    protected $commandBus;

    /** @var ContainerInterface */
    protected $container;

    /** @var LoggerInterface */
    protected $logger;

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



    /**
     * @param CommandInterface $command
     */
    abstract public function handle(CommandInterface $command);
}