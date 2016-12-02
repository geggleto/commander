<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 2:57 PM
 */

namespace Commander\Test\Handler;


use Commander\CommandInterface;
use Commander\CommandResponseInterface;
use Commander\Handler;
use Commander\Test\CommandResponse\UnitTestCommandResponse;

class UnitTestHandlerStop extends Handler
{
    protected $int;

    public function __construct($int = 0)
    {
        $this->int = $int;
    }

    /**
     * Does something with the command
     * @param CommandInterface $command
     *
     * @return CommandResponseInterface
     */
    public function handle(CommandInterface $command)
    {
        print $command->getData()['text'];

        $response = new UnitTestCommandResponse();
        $response->setContinue(false);
        return $response;
    }
}