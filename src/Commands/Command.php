<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 11:45 AM
 */

namespace Commander\Commands;
use Commander\Commands\CommandInterface;
use Commander\Events\EventBus;

/**
 * Class Command
 *
 * @package Commander
 */
class Command implements CommandInterface
{
    /** @var string  */
    protected $key;

    /** @var array  */
    protected $data;


    /**
     * Command constructor.
     *
     * @param string $key
     * @param array $data
     */
    public function __construct($key = '', array $data = [])
    {
        $this->key = $key;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }




}