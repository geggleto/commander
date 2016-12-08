<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 3:38 PM
 */

namespace Commander\Test\Events;


use Commander\Events\Event;

class DbHit extends Event
{
    const KEY = 'db.hit';

    protected $record;

    public static function make(array $payload) {
        return new CacheMiss(self::KEY, $payload);
    }

    /**
     * @return mixed
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @param mixed $record
     */
    public function setRecord($record)
    {
        $this->record = $record;
    }


}