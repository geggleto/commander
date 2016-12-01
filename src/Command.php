<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 11:45 AM
 */

namespace Commander;

/**
 * Class Command
 *
 * @package Commander
 */
abstract class Command implements CommandInterface
{
    /** @var string  */
    protected $key;

    /**
     * Command constructor.
     *
     * @param string $key
     */
    protected function __construct($key = '')
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}