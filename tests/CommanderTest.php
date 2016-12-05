<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-01
 * Time: 3:00 PM
 */

namespace Commander\Test;


use Commander\Commands\CommandBus;
use Commander\Responses\CommandResponse;
use Commander\Test\Container\TestContainer;
use Commander\Test\Handler\UnitTestHandler;
use Commander\Test\Handler\UnitTestHandlerStop;

class CommanderTest extends \PHPUnit_Framework_TestCase
{
    /** @var CommandBus */
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
        $this->commander = new CommandBus($this->container);
        $this->commander->add('test', 'testHandler');

        $command = Command\UnitTestCommand::makeCommand('test', ['text' => 'Hi']);
        $result = $this->commander->handle($command);

        $this->assertTrue($result);
        $this->expectOutputString("Hi");
    }

    public function testMultipleHandlers() {
        $commander = new CommandBus($this->container);
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');

        $this->assertCount(3, $commander->getList('test'));

        $command = Command\UnitTestCommand::makeCommand('test', ['text' => 'Hi']);
        $result = $commander->handle($command);

        $this->assertTrue($result);
        $this->expectOutputString("HiHiHi");
    }

    public function testMultipleHandlerAndStoppingExecution() {
        $h = new UnitTestHandler();
        $h2 = new UnitTestHandlerStop();
        $this->container->set('testHandler2', $h2);

        $commander = new CommandBus($this->container);
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler2');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');
        $commander->add('test', 'testHandler');

        $this->assertCount(7, $commander->getList('test'));

        $command = Command\UnitTestCommand::makeCommand('test', ['text' => 'Hi']);
        $result = $commander->handle($command);

        $this->assertInstanceOf(CommandResponse::class, $result);
        $this->expectOutputString("HiHiHiHi");
    }
}