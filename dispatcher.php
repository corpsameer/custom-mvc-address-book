<?php

class Dispatcher {
  /**
  * @property object $request Request received from the server
  */
  private $request;

  /**
  * Gets the requested controller and method from the request and
  * loads the controller with the requested actiona and sends the request parameters
  *
  */
  public function dispatch() {
    $this->request = new Request();
    Router::parse($this->request->url, $this->request);

    $controller = $this->loadController();

    call_user_func_array([$controller, $this->request->action], $this->request->params);
  }

  /**
  * Checks for the requested controller and if not found loads page not found
  *
  */
  public function loadController() {
    $name = $this->request->controller;
    $file = ROOT . 'Controllers/' . $name . '.php';

    $errorName = 'pageNotFound';
    $errorFile = ROOT . 'Controllers/' . $errorName . '.php';

    if (file_exists($file)) {
      require($file);
    } else {
      require($errorFile);
      $name = $errorName;
    }

    $controller = new $name();

    return $controller;
  }
}
?>
