<?php
class City extends Model {
  /**
  * Constructor
  */
  function __construct() {
    parent::__construct();
  }

  /**
  * Get list of all cities ordered by city name
  *
  * @return array
  */
  function getAllCities() {
    $sql = "SELECT * FROM " . TABLE_CITY . " ORDER BY city_name";

    $statement = $this->db->conn->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
  }
}
?>
