<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-02
 * Time: 11:49 AM
 */

namespace Commander;


interface CommandResponseInterface
{
    /**
     * @return bool
     */
    public function shouldContinue();

    /**
     * @return mixed
     */
    public function __toString();
}