# Commander

Micro-Service Command/Event Framework

Commander maps a HTTP Request to a Command Handler and listens for Framework Events.

## How to use

At it's core Commander does a lot of the heavy lifting for you.
You write CommandHandlers, and Commander does the rest.
You map the CommandHandlers to HTTP-Endpoints and that's it.

## Simple Example

```php
$commander = new Commander();
$this->commander->get('/user/{id}', 'user.cache.get', SimpleGetUserHandler::class);
$event = $commander->run();
print json_decode($event->getPayload()); //Return JSON Responses

//In SimpleGetUserHandler
class SimpleGetUserHandler extends Handler
{
    /**
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command)
    {
        $this->eventBus->notify(CompletedEvent::makeEvent(['id' => '1'])); //fill in the user info
    }
}
```

### Complicated Example...

Traditional DDD.
```php
class UserService {
    public function getUser($id) {
        
        $user = $this->cache->get('users', $id);
        
        if ($user==null) {
            $user = $db->query( ... );
        }
        
        return $user;
    }
    
    public function updateUser($id, $user) {
        $this->cache->update('users', $id, $user);
        
        $db->query( ... );
    }
```

This class will always require 2 dependencies... A Cache instance and a DB Instance.
Your application is very likely weighted heavily in terms of Reading rather than Writing.
So the DB ends up being wasted as a resource.


## Why ??

- Less Boilerplate. 
- Greater Testability.
- No Controllers or Controller Actions...
- Better Resource Usage



## Contributors

- Glenn Eggleton <geggleto@gmail.com>

