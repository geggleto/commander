# Commander

Micro-Service Command/Event Framework

Commander maps a HTTP Request to a Command Handler and listens for Framework Events.

## How to use

1) Write a Command Handler
    - Make sure to Fire `CompletedEvent`
    - Make sure to Fire `ErrorEvent`
2) Tell commander what end-point the handler is for
3) Do something with your Event

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

## Todo

- Add View Object
    - Add Renderers
        - Plates
        - Twig


## Contributors

- Glenn Eggleton <geggleto@gmail.com>

