<?php
class ResponseMiddleware {

  public function __invoke($request, $response, $next) {
    $response = $next($request, $response);
    $status = isset($_SESSION['http_status_code']) ? $_SESSION['http_status_code'] : null;
    return $response->withJson($_SESSION, $status);
  }

}
?>
