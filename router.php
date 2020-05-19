<?php

class Router {
  /**
  * Parses the url from the request and break URL to get information of requested controller and action
  *
  * @param string $url Requested url from the request
  * @param object $request Request object
  *
  */
  static public function parse($url, $request) {
    $url = trim($url);

    // Loads default contacts controller and index action
    if ($url == "/") {
      $request->controller = "contacts";
      $request->action = "index";
      $request->params = [];
    } else {
      // Breaks url into parts to get controller name, action and request params
      $explode_url = explode('/', $url);
      $explode_url = array_slice($explode_url, 1);      
      $request->controller = $explode_url[0] ?? 'Pagenotfound';
      $request->action = $explode_url[1] ?? 'index';
      $request->params = array_slice($explode_url, 2);
    }
  }
}
?>
