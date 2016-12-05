<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 2:58 PM
 */

namespace Commander\Test\Handlers;


use Commander\Commands\CommandBus;
use Commander\Commands\CommandInterface;
use Commander\Events\EventBus;
use Commander\Handlers\Handler;
use Commander\Responses\CommandResponse;


class FailedUserCacheHandler extends Handler
{

    public function __construct(EventBus $eventBus, CommandBus $commandBus)
    {
        parent::__construct($eventBus, $commandBus);
    }

    /**
     * @param CommandInterface $command
     *
     * @return CommandResponse
     */
    public function handle(CommandInterface $command)
    {
        $command->setKey('user.db.get');
        return $this->commandBus->handle($command);
    }
}