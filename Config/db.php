<?php

class Database {
  /**
  * @property string $conn Connection string for PDO database connecion
  */
  private static $conn = null;

  /**
  * Static function to get PDO database connection string
  */
  public static function getConn() {
    if(is_null(self::$conn)) {
      self::$conn = new PDO("mysql:host=localhost;dbname=todo_php", 'root', '');
    }

    return self::$conn;
  }
}
?>
