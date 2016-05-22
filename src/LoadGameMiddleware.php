<?php
class LoadGameMiddleware {

  public function __invoke($request, $response, $next) {
    $_SESSION['game'] = new TicTacToe($_SESSION['token']);
    $response = $next($request, $response);
    return $response;
  }

}
?>
