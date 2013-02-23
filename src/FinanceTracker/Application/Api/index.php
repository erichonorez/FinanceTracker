<?php
require dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/autoload.php';

$application = new Silex\Application();
$application['di'] = new FinanceTracker\Application\ApplicationContainer();

$application->get('/', function() use ($application) {
    return 'Hello ';
});

$application->run();