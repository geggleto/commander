<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-08
 * Time: 10:31 AM
 */

namespace Commander\Test\Handlers;

use Commander\Commands\CommandInterface;
use Commander\Events\CompletedEvent;
use Commander\Handlers\Handler;

class SimpleGetUserHandler extends Handler
{
    /**
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command)
    {
        $this->eventBus->notify(CompletedEvent::makeEvent(['id' => '1']));
    }
}