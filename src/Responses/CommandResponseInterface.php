<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-02
 * Time: 11:49 AM
 */

namespace Commander\Responses;


interface CommandResponseInterface
{
    /**
     * @return mixed
     */
    public function __toString();
}