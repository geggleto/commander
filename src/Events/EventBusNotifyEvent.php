<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-09
 * Time: 1:53 PM
 */

namespace Commander\Events;


class EventBusNotifyEvent extends Event
{
    public static function make(array $payload) {
        return new EventBusNotifyEvent('Framework.EventBus.Notify', $payload);
    }
}