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
use Psr\Log\LoggerInterface;

/**
 * Class Commander
 *
 * @package Commander
 */
class CommandBus
{
    /** @var array  */
    protected $list;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * Commander constructor.
     */
    public function __construct()
    {
        $this->list = [];
    }


    /**
     * Adds a handler to a key
     *
     * @param $key
     * @param Handler $handler
     *
     * @return $this
     *
     */
    public function add($key, Handler $handler) {
        if (!isset($this->list[$key])) {
            $this->list[$key] = [];
        }

        $this->list[$key] = $handler;

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
     * @param \Commander\Commands\CommandInterface $command
     * @return bool
     */
    public function handle(CommandInterface $command) {
        if (!$this->hasHandler($command->getKey())) {
            if ($this->logger) {
                $this->logger->error('No Handlers Found');
            }

            return false;
        }

        /** @var $class HandlerInterface */
        $class = $this->list[$command->getKey()];

        if ($class instanceof Handler) {
            if ($this->logger) {
                $this->logger->info('Dispatching '. $command->getKey() . " to " . get_class($class));
                $class->setLogger($this->logger);
            }
            $class->handle($command);

            return true;
        } else {
            if ($this->logger) {
                $this->logger->error("Handler Key `" . $command->getKey() . "` is not a command handler");
            }

            return false;
        }
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


}