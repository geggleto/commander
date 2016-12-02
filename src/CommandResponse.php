<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-02
 * Time: 11:48 AM
 */

namespace Commander;


abstract class CommandResponse implements CommandResponseInterface
{
    abstract public function __toString();
}