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

$app = new Slim\App(array('displayErrorDetails' => true));

require_once 'config/bootstrap.php';
$container = $app->getContainer();
$container['db'] = function ($c) {
  return getEntityManager();
};

$app->add(new LoadGameMiddleware($container));
$app->add(new SessionMiddleware());
$app->add(new ResponseMiddleware());
$app->add(new FlushDatabaseMiddleware($container));

$app->get('/', function ($request, $response, $args) {
  return $response->withStatus(302)->withHeader('Location', 'index.html');
});

$app->get('/mark/{row}/{column}', function ($request, $response, $args) {
  $game = $_SESSION['game'];
  if ($winner = $game->getWinner()) {
    $_SESSION['response']['message'] = "game finished, player '$winner' won";
  }
  else {
    $status = $game->mark($args['row'], $args['column'], 'X');
    $value = TicTacToeComputerPlayer::mark($game, 'O');
    $_SESSION['response']['message'] = $status;
    $_SESSION['response']['O'] = array('row' => $value[0], 'column' => $value[1]);
    $_SESSION['response']['X'] = array('row' => $args['row'], 'column' => $args['column']);
  }
  $this->db->persist($game);
  return $response;
});

$app->get('/reset', function ($request, $response, $args) {
  $game = $_SESSION['game'];
  if ($game) {
    $this->db->remove($game);
    $_SESSION['response']['message'] = 'game reseted';
  }
  return $response;
});

$app->get('/status', function ($request, $response, $args) {
  $game = $_SESSION['game'];
  if ($game) {
    $_SESSION['response']['grid'] = $game->getGrid();
    $_SESSION['response']['winner'] = $game->getWinner();
  }
  return $response;
});

$app->run();
