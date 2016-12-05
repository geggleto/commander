# Commander

Micro-Service Command Bus

### How it works

Commander works by mapping a HTTP Request to a `Command`. 
A `Command` will have a single `CommandHandler`.
A `CommandHandler` will issue one or more `Events` via the `EventBus` or issue one or more `Commands`.


### Getting Started

```php

$commander = new Commander(new Slim\App(), new EventBus());
$commander->get('/user/{id}', 'user.get', ReadUserCommandHandler::class);
$commander->post('/user', 'user.create', CreateUserCommandHandler::class);
$commander->run();
```

```php
class ReadUserCommandHandler extends Handler {

    public function handle(CommandInterface $command) {
        //Pull data from Cache
        $id = $command->getData()['id'];
        $item = $cache->get($id);
        if ($item === null) {
            $this->eventBus(new CacheMissEvent('cache.miss', ['id' => $id]);
        }
    }
}
```

