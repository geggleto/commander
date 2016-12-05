# Commander

Micro-Service Command Bus

## Terminology

### Command

A command represents a unit of work that needs to be completed.

### Command Handler

A command handler completes a unit of work by Raising one or more Events.

### Event

An event represents an action the system needs to complete

### Event Listener

An event listener does a piece of work, or queue's more commands.


### Usage

For any system function you will need at least:

1) CommandHandler

2) EventListener


### Example Application

Let's take a look at an example of how to display information about a user.

We will need the following Classes:

- RetreiveUserFromCacheHandler
- RetreiveUserFromCacheListener
- RetreiveUserFromDbHandler
- RetreiveUserFromDbListener

In this example we will explore how we can use Commands and Events to fall-back to a secondary pathway.
We will attempt to read from our Cache, and expect a failure.

We need to setup our `EventListeners`
```php
$eventBus = new EventBus();
$eventBus->addListener('user.db', RetreiveUserFromDbListener::class);
$eventBus->addListener('user.cache', RetreiveUserFromCacheListener::class);

$commander = new Commander(new \Slim\App(), $eventBus);
```

Next we need to register our `Listeners` in the application container (Which is Pimple).
```php
$container = $commander->getContainer();

$container[RetreiveUserFromDbListener::class] = function ($c) {
    return new RetreiveUserFromDbListener(new PDO(), $c['commandBus']);
};

$container[RetreiveUserFromCacheListener::class] = function ($c) {
    return new RetreiveUserFromCacheListener(new Cache(), $c['commandBus']);
};
```

We register our Handler to this HTTP End-Point
`$commander->get('/user/{id}', 'user.cache.get', RetreiveUserFromCacheHandler::class)`

Because we are setting up a fall-back path we need to register the Handler manually.

```php
$commandBus = $commander->getCommandBus();
$commandBus->add('user.db.get', RetreiveUserFromDbHandler::class);
```




