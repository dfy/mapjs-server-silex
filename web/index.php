<?php

require '../vendor/autoload.php';

use Silex\Application;

use IdeaMap\Predis\Client;
use IdeaMap\Predis\MapRepository;
use IdeaMap\Process\CreateMap;

$app = new Application();

$app->register(new Predis\Silex\PredisServiceProvider()/*, array(
    'predis.parameters' => 'tcp://127.0.0.1:6379',
    'predis.options'    => array('profile' => '2.2'),
)*/);
$app['idea.cmdbus'] = $app->share(function() {
    return 'nom';
});
$app['idea.repository.client'] = $app->share(function() use ($app) {
    return new Client($app['predis']);
});
$app['idea.repository'] = $app->share(function() use ($app) {
    return new MapRepository($app['idea.repository.client']);
});
$app['idea.process.createmap'] = $app->share(function() use ($app) {
    return new CreateMap($app['idea.repository']);
});

$app->get('/', function() use ($app) {
    $predis = $app['predis']; // @var $predis Predis\Client
    return '<p>Hello ' . $predis->get('mapjs:test:hello') . '</p>';
});

$app->get('/create', function() {
    return '<form method="post"><input type="text" name="name" /><input type="submit" value="submit" /></form>';
});

$app->post('/create', function() use ($app) {
    //$app['idea.process.createmap']
    var_dump($_POST);die;
});

$app->post('/api', function() {
    return json_encode(array('id' => 123, 'name' => 'joe'));
});

$app->get('/test', function() use ($app) {
    var_dump($app['idea.cmdbus']);die;
});

$app->run();