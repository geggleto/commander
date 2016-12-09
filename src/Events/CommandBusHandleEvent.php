<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-09
 * Time: 1:55 PM
 */

namespace Commander\Events;


class CommandBusHandleEvent extends Event
{
    public static function make(array $payload) {
        return new CommandBusHandleEvent('Framework.CommandBus.Handle', $payload);
    }
}