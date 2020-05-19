<?php
class Contact extends Model {
  /**
  * Constructor
  */
  function __construct() {
    parent::__construct();
  }

  /**
  * Get list of all contacts ordered by contact name
  *
  * @return array
  */
  function getContact($contactId = 0) {
    $sql = "SELECT a.*, b.* FROM " . TABLE_CONTACT . " a INNER JOIN " . TABLE_CITY . " b ON ";
    $sql .= "a.contact_city_id = b.city_id";

    if ($contactId != 0) {
      $sql .= " WHERE a.contact_id = '$contactId'";
    }

    $sql .= " ORDER BY a.contact_full_name";

    $statement = $this->db->conn->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
  }

  /**
  * Insert new contact details
  *
  * @param array $contactData Contact data
  *
  * @return int|boolean
  */
  function addContact($contactData) {
    $sql = "INSERT INTO " . TABLE_CONTACT . " (contact_first_name, contact_last_name, contact_full_name, contact_email, contact_street, contact_city_id, contact_zip_code)";
    $sql .= " VALUES (:contact_first_name, :contact_last_name, :contact_full_name, :contact_email, :contact_street, :contact_city_id, :contact_zip_code)";

    $statement = $this->db->conn->prepare($sql);
    if ($statement->execute([
      'contact_first_name' => $contactData['contact_first_name'],
      'contact_last_name' => $contactData['contact_last_name'],
      'contact_full_name' => $contactData['contact_full_name'],
      'contact_email' => $contactData['contact_email'],
      'contact_street' => $contactData['contact_street'],
      'contact_city_id' => $contactData['contact_city_id'],
      'contact_zip_code' => $contactData['contact_zip_code']
    ])) {
      return $this->db->conn->lastInsertId();
    } else {
      return false;
    }
  }

  /**
  * Update contact details of the given contact id
  *
  * @param int $contactId Contact id
  * @param array $contactData Contact data
  *
  * @return boolean
  */
  function updateContact($contactId, $contactData) {
    $sql = "UPDATE " . TABLE_CONTACT . " SET contact_first_name = :contact_first_name, contact_last_name = :contact_last_name, contact_full_name = :contact_full_name, ";
    $sql .= "contact_email = :contact_email, contact_street = :contact_street, contact_city_id = :contact_city_id, contact_zip_code = :contact_zip_code ";
    $sql .= "WHERE contact_id = :contact_id";

    $statement = $this->db->conn->prepare($sql);

    if ($statement->execute([
      'contact_id' => $contactId,
      'contact_first_name' => $contactData['contact_first_name'],
      'contact_last_name' => $contactData['contact_last_name'],
      'contact_full_name' => $contactData['contact_full_name'],
      'contact_email' => $contactData['contact_email'],
      'contact_street' => $contactData['contact_street'],
      'contact_city_id' => $contactData['contact_city_id'],
      'contact_zip_code' => $contactData['contact_zip_code']
    ])) {
      return true;
    }

    return false;
  }

  /**
  * Delete contact details of the given contact id
  *
  * @param int $contactId Contact id
  *
  * @return boolean
  */
  function deleteContact($contactId) {
    $sql = "DELETE FROM " . TABLE_CONTACT . " WHERE contact_id = :contact_id";
    $statement = $this->db->conn->prepare($sql);

    if ($statement->execute([
      'contact_id' => $contactId
    ])) {
      return true;
    }

    return false;
  }
}
?>
