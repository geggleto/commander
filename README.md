# Commander

Micro-Service Command/Event Framework

Commander maps a HTTP Request to a Command Handler and listens for Framework Events.


## How to use

1) Write a Command Handler
    - Make sure to Fire `CompletedEvent`
    - Make sure to Fire `ErrorEvent`
    
2) Tell commander what end-point the handler is for

3) Do something with your Event


## Use Cases

Currently we only support JSON APIs.


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

- CQRS!
- Less Boilerplate. 
- Greater Testability.
- No Controllers or Controller Actions...
- Better Resource Usage

## Framework Events

You can subscribe to the following Framework Events

- Framework.Complete
    - This event is raised when the response has been completed
    - Payload: `User Defined`
    
    
- Framework.Error
    - This event is raised if there has been an error somewhere
    - Payload: `User Defined` or Framework Errors are `["message" => "..."]`
    
    
- Framework.CommandBus.Handle
    - This event is fired when a Command Handler is about to be executed
    - Payload: `[CommandKey]`
    
    
- Framework.Invoke
    - This event is fired when a Command is about to be fired to the command bus
    - Payload: `["commandKey" => "", "commandClass" => ""]`
    
    
- Framework.EventBus.Notify
    - This event is fired when an Event is about to be sent to the EventBus.
    - Will not propagate Framework.EventBus.Notify's
    - Payload: `callable... [$object, "method"]`
    
    
    
## Todo

- Event Payloads
    - JsonPayload
    - TextPayload
    - XMLPayload


## Contributors

- Glenn Eggleton <geggleto@gmail.com>

