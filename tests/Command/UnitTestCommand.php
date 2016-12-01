<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 2:58 PM
 */

namespace Commander\Test\Command;


use Commander\Command;

class UnitTestCommand extends Command
{
    public static function makeCommand($key, array $data = []) {
        return new UnitTestCommand($key, $data);
    }
    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

}