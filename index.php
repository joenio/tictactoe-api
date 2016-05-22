<?php
require 'vendor/autoload.php';

spl_autoload_register(function ($classname) {
  require ('src/classes/' . $classname . '.php');
});

$app = new Slim\App();
$app->add(new SessionMiddleware());
$app->add(new ResponseMiddleware());

$app->get('/hello/{name}', function ($request, $response, $args) {
  $_SESSION['data'] = array('retorno' => "Hello, " . $args['name']);
});

$app->get('/new', function ($request, $response, $args) {
  $game = new TicTacToe();
  $response->write(json_encode(array('retorno' => "Hello, " . $args['name'])));
  return $response;
});

$app->run();
