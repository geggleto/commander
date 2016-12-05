<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 11:45 AM
 */

namespace Commander\Handlers;


use Commander\Commands\CommandInterface;
use Commander\Handlers\HandlerInterface;
use Commander\Responses\CommandResponseInterface;

abstract class Handler implements HandlerInterface
{
    /**
     * @param CommandInterface $command
     *
     * @return CommandResponseInterface
     */
    abstract public function handle(CommandInterface $command);
}