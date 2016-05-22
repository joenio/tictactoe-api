<?php
class FlushDatabaseMiddleware {

  private $db;
  public function __construct($container) {
    $this->db = $container->db;
  }

  public function __invoke($request, $response, $next) {
    $response = $next($request, $response);
    $this->db->flush();
    return $response;
  }

}
?>
