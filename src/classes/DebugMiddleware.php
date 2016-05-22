<?php
class DebugMiddleware {

  public function __invoke($request, $response, $next) {
    $response = $next($request, $response);
    $response->write("\n\n================ DEBUG ==================");
    $response->write("\n\nCOOKIE:\n");
    $response->write(json_encode($_COOKIE));
    $response->write("\n\nSESSION:\n");
    $response->write(json_encode($_SESSION));
    $response->write("\n\nREQUEST:\n");
    $response->write(json_encode($_REQUEST));
    return $response;
  }

}
?>
