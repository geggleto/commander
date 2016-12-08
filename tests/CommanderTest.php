<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-05
 * Time: 2:52 PM
 */

namespace Commander\Test;

use Commander\Commander;
use Commander\Test\Handlers\SimpleErrorThrowerHandler;
use Commander\Test\Handlers\SimpleGetUserHandler;
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


        $response = $this->commander->run(true);
        $response->getBody()->rewind();
        $this->assertEquals(json_encode(["id" => "1"]), (string)$response->getBody());
    }

    public function testSimpleErrorHandler() {
        $container = $this->commander->getApp()->getContainer();
        $container['request'] = $this->requestFactory();

        $this->commander->get('/user/{id}', 'user.cache.get', SimpleErrorThrowerHandler::class);

        $response = $this->commander->run(true);
        $response->getBody()->rewind();
        $this->assertEquals(json_encode(["error" => "message"]), (string)$response->getBody());
    }

    /**
     * @depends testSimpleErrorHandler
     */
    public function testNonSilentRun() {
        $container = $this->commander->getApp()->getContainer();
        $container['request'] = $this->requestFactory();

        $this->commander->get('/user/{id}', 'user.cache.get', SimpleErrorThrowerHandler::class);

        $this->commander->run();
        $this->expectOutputString(json_encode(["error" => "message"]));
    }
}