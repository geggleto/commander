# Commander

Micro-Service Command Bus

## Terminology

### Command

A command represents a unit of work that needs to be completed.

### Command Handler

A command handler completes a unit of work. 
Can Raise events to notify other parts of the system.

### Event

An event represents an action the system needs to complete

### Event Listener

An event listener does a piece of work.


### Usage

For any system function you will need at least:

1) CommandHandler

2) EventListener


### Example Application

Let's take a look at an example of how to display information about a user.

We will need the following Classes:

- RetreiveUserFromCacheHandler
- RetreiveUserFromDbHandler

In this example we will explore how we can use Commands and Events to fall-back to a secondary pathway.
We will attempt to read from our Cache, and expect a failure.

We need to setup our `EventListeners`
```php
$eventBus = new EventBus();
$commander = new Commander(new \Slim\App(), $eventBus);
```

We register our Handler to this HTTP End-Point. 
Using the HTTP methods add the Handler to Commander... Below we will register the Fallback manually.

`$commander->get('/user/{id}', 'user.cache.get', RetreiveUserFromCacheHandler::class)`

Because we are setting up a fall-back path we need to register the Handler manually.

```php
$commandBus = $commander->getCommandBus();
$commandBus->add('user.db.get', RetreiveUserFromDbHandler::class);
```

### Writing a Handler

All Handlers should extend from `Commander\Handlers\Handler`
All Handlers should return a `CommandResponse` Object

So let's take a look at Writing our first handler.

```php

class RetreiveUserFromCacheHandler extends Handler {
    
    protected $cache;
    
    public function __construct(Cache $cache, EventBus $eventBus, CommandBus $commandBus) {
        parent::__construct($eventBus, $commandBus);
        $this->cache = $cache;
    }
    
    public function handle(CommandInterface $command) {
        //We are going to try to read from the cache.
        $data = $command->getData;
        $item = $this->cache->get($data['id']);
        
        if (is_null($item)) {
            //Oh !@#$, the item doesn't exist... what do?!?!?!?
            
            //Simple, we fall back to reading from the DB
            $command->setKey('user.db.get'); //change the key so it gets handled differently
            
            $commandResponse = $this->commandBus->handle($command); //back to the bus
        
            //Maybe we should raise an event so we know stuff like this happens
            //Gotta love analytics!
            $this->eventBus->notify(new CacheMissEvent($command));
            
            return $commandResponse;
        
        } else {
            return new JsonCommandResponse($item);
        }
    }
}
```


# Todo

- [ ] - Create JsonCommandResponse
- [ ] - Create HtmlCommandResponse
- [ ] - Events