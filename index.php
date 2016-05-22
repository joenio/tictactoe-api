<?php
require 'vendor/autoload.php';

spl_autoload_register(function ($classname) {
  if (file_exists('src/classes/' . $classname . '.php')) {
    require ('src/classes/' . $classname . '.php');
  }
  else {
    require ('src/' . $classname . '.php');
  }
});

$app = new Slim\App();
$app->add(new LoadGameMiddleware());
$app->add(new SessionMiddleware());
$app->add(new ResponseMiddleware());
$app->add(new DebugMiddleware());

require_once 'config/bootstrap.php';
$container = $app->getContainer();
$container['db'] = function ($c) {
  return getEntityManager();
};

$app->get('/hello/{name}', function ($request, $response, $args) {
  $_SESSION['data'] = array('retorno' => "Hello, " . $args['name']);
});

$app->get('/mark/{row}/{column}', function ($request, $response, $args) {
  $game = $_SESSION['game'];
  $game->mark($args['row'], $args['column']);
  $this->db->persist($game);
  $this->db->flush();
  #$bean->update();
  return $response;
});

$app->run();
