<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 3:01 PM
 */

namespace Commander\Test\Container;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Interop\Container\Exception\NotFoundException;

class TestContainer implements ContainerInterface
{
    protected $container;

    public function __construct()
    {
        $this->container = [];
    }

    public function set($id, $value) {
        $this->container[$id] = $value;
    }

    public function get($id)
    {
        return $this->container[$id];
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($id)
    {
        return isset($this->container[$id]);
    }
}