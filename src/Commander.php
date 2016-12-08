<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2016-12-02
 * Time: 1:07 PM
 */

namespace Commander;

use Commander\Commands\Command;
use Commander\Commands\CommandBus;
use Commander\Commands\CommandInterface;
use Commander\Events\Event;
use Commander\Events\EventBus;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;

class Commander
{
    /** @var CommandBus */
    protected $commandBus;

    /** @var App */
    protected $app;

    /** @var EventBus  */
    protected $eventBus;

    /** @var Event */
    protected $event;

    /**
     * Commander constructor.
     *
     * @param callable|null $onCompleteReceiver
     * @param callable|null $onErrorReceiver
     */
    public function __construct(callable $onCompleteReceiver = null, callable $onErrorReceiver = null)
    {
        $this->commandBus = new CommandBus();
        $this->eventBus = new EventBus();
        $this->app = new App();

        if (is_null($onCompleteReceiver)) {
            $this->eventBus->addListener('Framework.Complete', [$this, 'onComplete']);
        }

        if (is_null($onErrorReceiver)) {
            $this->eventBus->addListener('Framework.Error', [$this, 'onError']);
        }
    }

    /**
     * @return CommandBus
     */
    public function getCommandBus()
    {
        return $this->commandBus;
    }

    /**
     * @return EventBus
     */
    public function getEventBus()
    {
        return $this->eventBus;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return App
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     *
     * $bridge->map(['POST'], '/user', 'user.register', UserRegisterCommand::class);
     *
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

        $handler = new $commandClass($this->eventBus, $this->commandBus, $this->app->getContainer());

        $this->commandBus->add($commandKey, $handler);

        return $route;
    }


    /**
     * @param $pattern
     * @param $commandKey
     * @param array $commandClass
     */
    public function post($pattern, $commandKey, $commandClass) {
        $this->map(['POST'], $pattern, $commandKey, $commandClass);
    }


    /**
     * @param $pattern
     * @param $commandKey
     * @param array $commandClass
     */
    public function get($pattern, $commandKey, $commandClass) {
        $this->map(['GET'], $pattern, $commandKey, $commandClass);
    }


    /**
     * @param $pattern
     * @param $commandKey
     * @param array $commandClass
     */
    public function put($pattern, $commandKey, $commandClass) {
        $this->map(['PUT'], $pattern, $commandKey, $commandClass);
    }


    /**
     * @param $pattern
     * @param $commandKey
     * @param array $commandClass
     */
    public function delete($pattern, $commandKey, $commandClass) {
        $this->map(['DELETE'], $pattern, $commandKey, $commandClass);
    }


    /**
     * @param $pattern
     * @param $commandKey
     * @param array $commandClass
     */
    public function options($pattern, $commandKey, $commandClass) {
        $this->map(['OPTIONS'], $pattern, $commandKey, $commandClass);
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

        $body = is_array($request->getParsedBody()) ? $request->getParsedBody() : [];

        /** @var $command CommandInterface */
        $command = new Command($commandKey, array_merge($body, $args));

        $this->commandBus->handle($command);
    }

    /**
     * @return Event
     * @throws \Exception
     */
    public function run() {
        $this->app->__invoke($this->app->getContainer()['request'], new Response());

        //if $event is null then Nothing emitted the onComplete event or onError event...
        //we should do something about it
        if (is_null($this->event)) {
            throw new \Exception("No Event Thrown.");
        }

        return $this->event;
    }

    public function onComplete(Event $event) {
        $this->event = $event;
    }

    public function onError(Event $event) {
        $this->event = $event;
    }
}