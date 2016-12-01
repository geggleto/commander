# Commander

Container-Interop aware Command Bus

### Usage
```php
//Initialize Commander
$commander = new Commander($container);
$commander->add('command.user.regsiter', 'UserRegisterDbHandlder');
$commander->add('command.user.regsiter', 'UserRegisterEmailHandlder');
$commander->add('command.user.regsiter', 'UserRegisterStatisticHandlder');

//.. Someplace else...
$commander->handle(new UserRegisterCommand());
//Issues the command to the 3 handlers defined
```