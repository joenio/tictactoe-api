<?php
class SessionMiddleware {

  private function validate_session() {
    $token = $_SESSION['token'];
    if(! preg_match('/^[[:xdigit:]]{32}$/', $token)) {
      $_SESSION['http_status_code'] = 401;
    }
  }

  private function create_or_restore_session($token) {
    if (empty($token)) {
      $_SESSION['token'] = md5(uniqid(rand(), true));
    }
    else {
      $_SESSION['token'] = $token;
    }
  }

  public function __invoke($request, $response, $next) {
    $this->create_or_restore_session($request->getParam('token'));
    $this->validate_session();
    $response = $next($request, $response);
    return $response;
  }

}
?>
