<?php

require '../vendor/autoload.php';

use Silex\Application;

$app = new Application();

$app->register(new Predis\Silex\PredisServiceProvider()/*, array(
    'predis.parameters' => 'tcp://127.0.0.1:6379',
    'predis.options'    => array('profile' => '2.2'),
)*/);

$app->get('/', function() use ($app) {
    $predis = $app['predis']; // @var $predis Predis\Client
    return '<p>Hello ' . $predis->get('mapjs:test:hello') . '</p>';
});

$app->post('/api', function() {
    return json_encode(array('id' => 123, 'name' => 'joe'));
});

$app->run();