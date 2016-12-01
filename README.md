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

### Detailed Example
```php

$app = new Slim\App();

$container = $app->getContainer();

$container['commander'] = function ($c) {
    $commander = new Commander($c);
    $commander->add('command.user.regsiter', 'UserRegisterDbHandlder');
    $commander->add('command.user.regsiter', 'UserRegisterEmailHandlder');
    $commander->add('command.user.regsiter', 'UserRegisterStatisticHandlder');
        
    return $commander;
};

$container['UserRegisterDbHandlder'] = function ($c) {
    return new UserRegisterDbHandlder();
};


$container['UserRegisterEmailHandlder'] = function ($c) {
    return new UserRegisterEmailHandlder();
};

$container['UserRegisterStatisticHandlder'] = function ($c) {
    return new UserRegisterStatisticHandlder();
};


$app->post('/user', function ($request, $response, $args) {
    try {
        $result = $this->get('commander')->handle(new UserRegisterCommand($request->getParsedBody()));
        if ($result) {
            return $response->withStatus(200);
        } else {
            return $response->withStatus(400);s
        }
    } catch (Exception $e) {
        return $response->withStatus(500);
    }
});

$app->run();

```