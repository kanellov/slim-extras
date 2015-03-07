<?php
require __DIR__ . '/../vendor/autoload.php';

use FUnit as fu;
use Knlv\Slim\Middleware\Callback;

date_default_timezone_set('Europe/Athens');

fu::test('Test middleware throws exception on invlalid callable', function () {
    try {
        new Callback('test');
    } catch (Exception $e) {
        fu::ok($e instanceof InvalidArgumentException, 'Throws if no callback is given');
    }
});

fu::test('Test middleware set callback', function () {
    $callback           = function () {};
    $middleware         = new Callback($callback);
    $reflection         = new ReflectionObject($middleware);
    $propertyReflection = $reflection->getProperty('callback');
    $propertyReflection->setAccessible(true);
    fu::equal($callback, $propertyReflection->getValue($middleware), 'Callback is set');
});

fu::test('Test middleware call uses callback', function () {
    $middleware = new Callback(function ($m) use (&$middleware) {
        fu::pass('Callable is called');
        fu::equal($middleware, $m, 'Passes itself as callable argument');
    });
    $middleware->call();
});
