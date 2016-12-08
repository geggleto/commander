<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 3:28 PM
 */

namespace Commander\Test\Events;


use Commander\Events\Event;

class DbMiss extends Event
{
    const KEY = 'db.miss';

    public static function make(array $payload) {
        return new DbMiss(self::KEY, $payload);
    }
}