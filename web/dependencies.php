<?php

use Silex\Application;

use SimpleCommand\Predis\Client;
use SimpleCommand\Predis\MapRepository;
use IdeaMapApp\Process\CreateMap;
use IdeaMapApp\Service\Map as MapService;
use IdeaMapApp\CommandSerializer;

if (!isset($app)) {
    $app = new Application();
}

$app->register(new Predis\Silex\PredisServiceProvider(), $predisConfig);

$app['idea.cmdbus'] = $app->share(function() {
    return 'nom';
});
$app['idea.commandserializer'] = $app->share(function() use ($app) {
    return new CommandSerializer();
});
$app['idea.repository.client'] = $app->share(function() use ($app) {
    return new Client($app['predis']);
});
$app['idea.repository'] = $app->share(function() use ($app) {
    return new MapRepository($app['idea.repository.client'], $app['idea.commandserializer']);
});
$app['idea.process.createmap'] = $app->share(function() use ($app) {
    return new CreateMap($app['idea.repository']);
});
$app['idea.service.map'] = $app->share(function() use ($app) {
    return new MapService(
        $app['idea.repository'],
        $app['idea.process.createmap'],
        $app['idea.commandserializer']
    );
});
