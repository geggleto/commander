<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 11:45 AM
 */

namespace Commander;


interface CommandInterface
{
    /**
     * @return string
     */
    public function getKey();

    public function getData();
}