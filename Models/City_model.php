<?php
class City extends Model {
  /**
  * Constructor
  */
  public function __construct() {
    parent::__construct();
  }

  /**
  * Get list of all cities ordered by city name
  */
  public function getAllCities() {
    $query = "SELECT * FROM " . TABLE_CITY . " ORDER BY `city_name`";

    $statement = $this->db->conn->prepare($query);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
  }
}
?>
