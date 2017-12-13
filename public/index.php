<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    //Say "Hello Mark" http://localhost/slimRestAPI/public/index.php/hello/Mark
    $response->getBody()->write("Hello, $name");

    return $response;
});
$app->run();