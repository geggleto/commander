<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 11:45 AM
 */

namespace Commander;


abstract class Handler implements HandlerInterface
{
    /**
     * @param CommandInterface $command
     *
     * @return bool
     */
    abstract public function handle(CommandInterface $command);
}