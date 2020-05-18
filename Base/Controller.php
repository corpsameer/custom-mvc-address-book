<?php

class Controller {
  /**
  * @property array $vars Array of data to be sent to view from controller
  */
  var $vars = [];

  /**
  * @property string $layout basic layout to load default template for views
  */
  var $layout = "default";

  /**
  * Stores the data in vars array to be made accessible in view
  *
  * @param array $data Data to be accessed in view
  *
  */
  function setData($data) {
    $this->vars = array_merge($this->vars, $data);
  }

  /**
  * Renders the view of the requested file
  *
  * @param array $filename View to be rendered
  *
  */
  function renderView($filename) {
    extract($this->vars);
    ob_start();
    require(ROOT . "Views/" . ucfirst(get_class($this)) . '/' . $filename . '.php');
    $content = ob_get_clean();

    // Check if default layout is disabled for the view. If disabled, show only the content of this view.
    // Else load the layout for the view
    if ($this->layout == false) {
      $content;
    }  else {
        require(ROOT . "Views/Layouts/" . $this->layout . '.php');
    }
  }

  /**
  * Sanitizes form data to remove special and html chars from form data
  *
  * @param array $data Data to be sanitized
  *
  */
  private function santizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /**
  * Gets form data submotted and sanitizes each field data submitted
  *
  * @param array $form Form data
  *
  */
  protected function sanitizeForm($form) {
    foreach ($form as $key => $value) {
      $form[$key] = $this->santizeData($value);
    }
  }
}
?>
