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

require_once 'config/bootstrap.php';
$container = $app->getContainer();
$container['db'] = function ($c) {
  return getEntityManager();
};

$app->add(new LoadGameMiddleware($container));
$app->add(new SessionMiddleware());
$app->add(new ResponseMiddleware());
$app->add(new DebugMiddleware());
$app->add(new FlushDatabaseMiddleware($container));

$app->get('/mark/{row}/{column}', function ($request, $response, $args) {
  $game = $_SESSION['game'];
  $game->mark($args['row'], $args['column']);
  $this->db->persist($game);
  return $response;
});

$app->get('/abort', function ($request, $response, $args) {
  $game = $_SESSION['game'];
  if ($game) {
    $this->db->remove($game);
  }
  return $response;
});

$app->get('/grid', function ($request, $response, $args) {
  $game = $_SESSION['game'];
  if ($game) {
    $_SESSION['response']['grid'] = $game->getGrid();
  }
  return $response;
});

$app->run();
