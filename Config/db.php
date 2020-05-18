<?php

class Database {
  /**
  * @property string $conn Connection string for PDO database connecion
  */
  public $conn;

  /**
  * @property object $dbInstance DB instance object
  */
  private static $dbInstance;

  /**
  * Constructor to create PDO connection string to database
  */
  private function __construct() {
    $this->conn = new PDO("mysql:host=localhost;dbname=address_book", 'root', '');
  }

  /**
  * Static function to create database instance using singleton pattern
  */
  public static function getDbInstance() {
    if(!isset(self::$dbInstance)) {
      $object = __CLASS__;
      self::$dbInstance = new $object;
    }

    return self::$dbInstance;
  }
}
?>
