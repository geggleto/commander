<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 11:12 AM
 */

namespace Commander\Events;


interface ListenerInterface
{
    public function receive(Event $event);
}