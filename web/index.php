<?php

require '../vendor/autoload.php';

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use IdeaMap\Predis\Client;
use IdeaMap\Predis\MapRepository;
use IdeaMap\Process\CreateMap;
use IdeaMap\Service\Map as MapService;
use IdeaMap\CommandSerializer;

// config

$predisConfig = array(
    'predis.parameters' => 'tcp://127.0.0.1:6379'
);
if ($_SERVER['SERVER_NAME'] == 'test.mapjs-server.local') {
    $predisConfig = array(
        'predis.parameters' => array(
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' => 2
        )
    );
} // 'predis.options'    => array('profile' => '2.2')

// dependencies

$app = new Application();

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

// routes

$app->get('/', function() use ($app) {
    $predis = $app['predis']; // @var $predis Predis\Client
    return '<p>Hello ' . $predis->get('mapjs:test:hello') . '</p>';
});

$app->get('/create', function() {
    return '<form method="post"><input type="text" name="title" /><input type="submit" value="submit" /></form>';
});

$app->post('/create', function() use ($app) {
    $id = $app['idea.service.map']->create($_POST['title']);
    return $app->redirect("/map/$id");
});

$app->get('/map/{id}', function(Silex\Application $app, $id) {
    /*$subRequest = Request::create("/map-events/$id", 'GET');
    return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);*/
    return '

<script>
    var source = new EventSource("/map-events/5");
    console.log(source);
    source.addEventListener("message", function(e) {
        var data = JSON.parse(e.data);
        console.log(data);
    }, false);
</script>

    ';
});

$app->post('/map/{id}', function(Request $request) {
    return new Response($request->getContent(), 202);
});

$app->get('/map-events/{id}', function(Silex\Application $app, Request $request, $id) {
    $lastEventId = $request->headers->get('Last-Event-ID');
    $eventList = '';

    if (is_null($lastEventId)) {
        foreach ($app['idea.service.map']->eventList($id) as $cmd) {
            $eventList .= 'id: 1' . "\n";
            $eventList .= 'data: ' . json_encode($cmd) . "\n\n";
        }
    } else if ($lastEventId === 1) {
        $eventList .= 'id: 2' . "\n";
        $eventList .= 'data: ' . json_encode(array($lastEventId)) . "\n\n";
    }

    $response = new Response($eventList);
    $response->headers->set('Content-Type', 'text/event-stream');
    $response->setCharset('UTF-8');
    return $response;
});


$app->post('/api', function() {
    return json_encode(array('id' => 123, 'title' => 'joe'));
});

$app->get('/test', function() use ($app) {
    var_dump($app['idea.cmdbus']);die;
});

// end

$app->run();