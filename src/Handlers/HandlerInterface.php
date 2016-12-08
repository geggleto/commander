<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 11:45 AM
 */

namespace Commander\Handlers;


use Commander\Commands\CommandInterface;
use Commander\Responses\CommandResponseInterface;

interface HandlerInterface
{
    /**
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command);
}