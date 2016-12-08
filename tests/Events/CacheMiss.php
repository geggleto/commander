<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 3:28 PM
 */

namespace Commander\Test\Events;


use Commander\Events\Event;

class CacheMiss extends Event
{
    const KEY = 'cache.miss';

    public static function make(array $payload) {
        return new CacheMiss(self::KEY, $payload);
    }
}