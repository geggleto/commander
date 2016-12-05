<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-02
 * Time: 11:53 AM
 */

namespace Commander\Test\CommandResponse;


use Commander\Responses\CommandResponse;

class UnitTestCommandResponse extends CommandResponse
{
    protected $continue;

    public function __construct()
    {
    }

    public function __toString()
    {
        return "";
    }

    /**
     * @param bool $continue
     */
    public function setContinue($continue = true)
    {
        $this->continue = $continue;
    }



    /**
     * @return bool
     */
    public function shouldContinue()
    {
        return $this->continue;
    }
}