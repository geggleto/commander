<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-02
 * Time: 1:07 PM
 */

namespace Commander\Bridges;

use Commander\Commander;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;

class SlimBridge
{
    /** @var Commander */
    protected $commander;

    /** @var \Slim\App */
    protected $app;

    /**
     * SlimBridge constructor.
     *
     * @param \Slim\App $app
     * @param Commander $commander
     */
    public function __construct(\Slim\App $app, Commander $commander)
    {
        $this->commander = $commander;
        $this->app = $app;
    }

    /**
     * @param array $verbs
     * @param string $pattern
     * @param string $commandKey
     * @param string $commandClass
     *
     * @return \Slim\Interfaces\RouteInterface
     */
    public function map(array $verbs, $pattern = '', $commandKey = '', $commandClass = '') {
        $route = $this->app->map($verbs, $pattern, [$this, "__invoke"]);
        $route->setArgument('commandKey', $commandKey);
        $route->setArgument('commandClass', $commandClass);

        return $route;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = [])
    {
        /** @var $route Route */
        $route = $request->getAttribute('route');
        $commandKey = $route->getArgument('commandKey');
        $commandClass = $route->getArgument('commandClass');

        $command = new $commandClass($commandKey, array_merge($request->getParsedBody(), $args));

        $handlerResponse = $this->commander->handle($command);

        return $response->write((string)$handlerResponse);
    }
}