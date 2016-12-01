<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 3:00 PM
 */

namespace Commander\Test;


use Commander\Commander;
use Commander\Test\Container\TestContainer;
use Commander\Test\Handler\UnitTestHandler;

class CommanderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Commander */
    protected $commander;

    /** @var  TestContainer */
    protected $container;

    public function setUp() {
        $container = new TestContainer();
        $h = new UnitTestHandler();
        $container->set('testHandler', $h);

        $this->container = $container;
    }

    public function testHandleCommand() {
        $this->commander = new Commander($this->container);
        $this->commander->add('test', 'testHandler');

        $command = Command\UnitTestCommand::makeCommand('test', ['test' => 'Hi']);
        $result = $this->commander->handle($command);

        $this->assertTrue($result);
        $this->expectOutputString("Hi");
    }

    public function testMultipleHandlers() {
        $commander = new Commander($this->container);
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');

        $this->assertCount(3, $commander->getList('test'));

        $command = Command\UnitTestCommand::makeCommand('test', ['test' => 'Hi']);
        $result = $commander->handle($command);

        $this->assertTrue($result);
        $this->expectOutputString("HiHiHi");
    }

    public function testMultipleHandlerAndStoppingExecution() {
        $h = new UnitTestHandler(4);
        $this->container->set('testHandler2', $h);

        $commander = new Commander($this->container);
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler2');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');

        $this->assertCount(7, $commander->getList('test'));

        $command = Command\UnitTestCommand::makeCommand('test', ['test' => 'Hi', 'stop' => true, 'int' => 4]);
        $result = $commander->handle($command);

        $this->assertFalse($result);
        $this->expectOutputString("HiHiHiHi");
    }
}