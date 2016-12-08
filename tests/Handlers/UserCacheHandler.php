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


class UserCacheHandler extends Handler
{
    /**
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command)
    {
        $response = new CommandResponse();
        $response->setPayload([
            'id' => $command->getData()['id']
        ]);
        return $response;
    }
}