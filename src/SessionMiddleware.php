<?php
class SessionMiddleware {

  private function token_is_valid($token) {
    return preg_match('/^[[:xdigit:]]{32}$/i', $token);
  }

  private function clear_session() {
    setcookie('token', null);
    $_SESSION['token'] = null;
  }

  private function start_session() {
    $token = md5(uniqid(rand(), true));
    setcookie('token', $token);
    $_SESSION['token'] = $token;
  }

  public function __invoke($request, $response, $next) {
    $token = $_SESSION['token'] = $_COOKIE['token'];
    if (empty($token)) {
      $this->start_session();
    }
    elseif(! $this->token_is_valid($token)) {
      $this->clear_session();
      $_SESSION['http_status_code'] = 401;
      $_SESSION['message'] = "token '$token' is invalid";
    }
    $response = $next($request, $response);
    return $response;
  }

}
?>
