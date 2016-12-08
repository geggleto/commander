<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 2:52 PM
 */

namespace Commander\Test;


use Commander\Commander;
use Commander\Events\CompletedEvent;
use Commander\Events\ErrorEvent;
use Commander\Events\EventBus;
use Commander\Test\Handlers\FailedUserCacheHandler;
use Commander\Test\Handlers\SimpleErrorThrowerHandler;
use Commander\Test\Handlers\SimpleGetUserHandler;
use Commander\Test\Handlers\UserCacheHandler;
use Commander\Test\Handlers\UserDbHandler;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\UploadedFile;
use Slim\Http\Uri;

class CommanderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Commander */
    protected $commander;

    public function setUp()
    {
        $this->commander = new Commander();
    }

    public function requestFactory($method = 'GET', $uri = 'https://example.com/user/1')
    {
        $env = Environment::mock();
        $uri = Uri::createFromString($uri);
        $headers = Headers::createFromEnvironment($env);
        $serverParams = $env->all();
        $body = new RequestBody();
        $uploadedFiles = UploadedFile::createFromEnvironment($env);
        $request = new Request($method, $uri, $headers, [], $serverParams, $body, $uploadedFiles);
        return $request;
    }

    public function testSimpleCommandHandler() {
        $container = $this->commander->getApp()->getContainer();
        $container['request'] = $this->requestFactory();

        $this->commander->get('/user/{id}', 'user.cache.get', SimpleGetUserHandler::class);

        $event = $this->commander->run();

        $this->assertEquals(['id' => "1"], $event->getPayload());
        $this->assertInstanceOf(CompletedEvent::class, $event);
    }

    public function testSimpleErrorHandler() {
        $container = $this->commander->getApp()->getContainer();
        $container['request'] = $this->requestFactory();

        $this->commander->get('/user/{id}', 'user.cache.get', SimpleErrorThrowerHandler::class);

        $event = $this->commander->run();

        $this->assertEquals(['error' => "message"], $event->getPayload());
        $this->assertInstanceOf(ErrorEvent::class, $event);
    }
}