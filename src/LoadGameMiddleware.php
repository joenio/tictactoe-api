<?php
class LoadGameMiddleware {

  private $db;
  public function __construct($container) {
    $this->db = $container->db;
  }

  public function __invoke($request, $response, $next) {
    $game = $this->db->find('TicTacToe', $_SESSION['token']);
    if (! $game) {
      $game = new TicTacToe($_SESSION['token']);
      $this->db->persist($game);
    }
    $_SESSION['game'] = $game;
    $response = $next($request, $response);
    return $response;
  }

}
?>
