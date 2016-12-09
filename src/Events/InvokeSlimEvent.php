<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-09
 * Time: 1:50 PM
 */

namespace Commander\Events;


class InvokeSlimEvent extends Event
{
    public static function make(array $payload) {
        return new InvokeSlimEvent('Framework.Invoke', $payload);
    }
}