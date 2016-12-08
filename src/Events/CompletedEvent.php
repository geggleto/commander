<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-08
 * Time: 10:33 AM
 */

namespace Commander\Events;


class CompletedEvent extends Event
{
    public static function makeEvent(array $payload = []) {
        return new CompletedEvent('Framework.Complete', $payload);
    }
}