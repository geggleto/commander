<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 11:35 AM
 */

namespace Commander;


use Interop\Container\ContainerInterface;

/**
 * Class Commander
 *
 * @package Commander
 */
class Commander
{
    /** @var array  */
    protected $list;

    /** @var ContainerInterface  */
    protected $container;

    /** @var \Slim\App  */
    protected $app;


    /**
     * Commander constructor.
     * @param \Slim\App $app
     */
    public function __construct(\Slim\App $app)
    {
        $this->list = [];
        $this->container = $app->getContainer();
        $this->app = $app;
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

        $this->list[$key][] = $handlerKey;

        return $this;
    }

    /**
     * @return array
     */
    public function getList($key)
    {
        return $this->list[$key];
    }



    /**
     * Handles a command
     *
     * @param CommandInterface $command
     *
     * @return CommandResponse|true true on success false when a handler terminated the stack
     *
     * @throws \Exception When a handler does not implement HandlerInterface
     * @throws \InvalidArgumentException When No handlers are found for a command
     */
    public function handle(CommandInterface $command) {
        if (!isset($this->list[$command->getKey()]) || empty($this->list[$command->getKey()])) {
            throw new \InvalidArgumentException("No handlers found");
        }

        $handlers = $this->list[$command->getKey()];

        foreach ($handlers as $handler) {
            /** @var $handlerService HandlerInterface */
            $handlerService = $this->container->get($handler);

            if ($handlerService instanceof HandlerInterface) {
                $response = $handlerService->handle($command);
                if ($response->shouldContinue() === false) {
                    return $response;
                }
            } else {
                throw new \Exception("Handler Key `" . $handler . "` is not a command handler");
            }
        }

        return true;
    }
}