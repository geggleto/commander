<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 11:35 AM
 */

namespace Commander\Commands;


use Commander\Commands\CommandInterface;
use Commander\Handlers\Handler;
use Commander\Handlers\HandlerInterface;
use Commander\Responses\CommandResponse;
use Interop\Container\ContainerInterface;

/**
 * Class Commander
 *
 * @package Commander
 */
class CommandBus
{
    /** @var array  */
    protected $list;

    /** @var ContainerInterface  */
    protected $container;

    /**
     * Commander constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->list = [];
        $this->container = $container;
    }


    /**
     * Adds a handler to a key
     *
     * @param $key
     * @param $handlerKey
     *
     * @return $this
     */
    public function add($key, $handlerKey = '') {
        if (!isset($this->list[$key])) {
            $this->list[$key] = [];
        }

        $this->list[$key] = $handlerKey;

        return $this;
    }


    /**
     * @return string
     */
    public function getHandler($key)
    {
        return $this->list[$key];
    }


    /**
     * @param $key
     *
     * @return bool
     */
    public function hasHandler($key) {
        return (isset($this->list[$key]));
    }


    /**
     * Handles a command
     *
     * @param CommandInterface $command
     *
     * @return CommandResponse true on success false when a handler terminated the stack
     *
     * @throws \Exception When a handler does not implement HandlerInterface
     * @throws \InvalidArgumentException When No handlers are found for a command
     */
    public function handle(CommandInterface $command) {
        if (!$this->hasHandler($command->getKey())) {
            throw new \InvalidArgumentException("No handlers found");
        }

        $class = $this->list[$command->getKey()];

        $handlerService = new $class($this->container['eventBus']);

        if ($handlerService instanceof Handler) {

            return $handlerService->handle($command);
        } else {
            throw new \Exception("Handler Key `" . $command->getKey() . "` is not a command handler");
        }
    }
}