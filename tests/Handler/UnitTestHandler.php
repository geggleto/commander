<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 2:57 PM
 */

namespace Commander\Test\Handler;


use Commander\CommandInterface;
use Commander\Handler;

class UnitTestHandler extends Handler
{
    protected $int;

    public function __construct($int = 0)
    {
        $this->int = $int;
    }

    /**
     * @param CommandInterface $command
     *
     * @return bool
     */
    public function handle(CommandInterface $command)
    {
        print $command->getData()['test'];

        if (isset($command->getData()['stop'])) {
            if ($command->getData()['int'] == $this->int) {
                return false;
            }
        }

        return true;
    }
}