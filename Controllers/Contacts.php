<?php
class Contacts extends Controller {
  /**
  * Shows list of all contacts in the address book
  *
  */
  function index() {
    $contact = $this->loadModel('Contact');

    $data['cities'] = $this->getCities();

    $this->setData($data);
    $this->renderView("index");
  }

  /**
  * Gets details of all the cities
  */
  function getCities() {
    $city = $this->loadModel('City');

    $cities = $city->getAllCities();

    return $cities;
  }
}
?>
