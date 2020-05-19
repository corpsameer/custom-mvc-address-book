<?php
class Contacts extends Controller {
  /**
  * Shows list of all contacts in the address book
  *
  */
  function index() {
    $city = $this->loadModel('City');

    $data['cities'] = $city->getAllCities();

    $this->setData($data);
    $this->renderView("index");
  }

  /**
  * Gets details of the contact for the given contact id
  *
  * @param int $contactId Contact id
  *
  */
  function getContactDetails($contactId = 0) {
    $response = [
      "status" => INTERNAL_SERVER_ERROR,
      "message" => "Server Error!! Please try again"
    ];
    $contact = $this->loadModel('Contact');
    $contactId = $this->santizeData($contactId);

    $contactDetails = $contact->getContact($contactId);

    $response = [
      "status" => SUCCESS_REQUEST,
      "message" => "Contact found.",
      "data" => $contactDetails
    ];

    echo json_encode($response);
  }

  /**
  * Create new contact
  */
  function newContact() {
    $response = [
      "status" => INTERNAL_SERVER_ERROR,
      "message" => "Server Error!! Please try again."
    ];
    $postVars = $_POST;

    $isValidRequest = $this->checkPostFields($postVars);

    if (empty($isValidRequest)) {
      $contact = $this->loadModel('Contact');
      $postVars = $this->sanitizeForm($postVars);
      $postVars['contact_full_name'] = $postVars['contact_first_name'] . " " . $postVars['contact_last_name'];

      $newContact = $contact->addContact($postVars);

      if ($newContact) {
        $response = [
          "status" => SUCCESS_REQUEST,
          "message" => "Contact added succesfully."
        ];
      }
    } else {
      $response = [
        "status" => INVALID_REQUEST,
        "message" => $isValidRequest
      ];
    }

    echo json_encode($response);
  }

  /**
  * Edit contact details
  *
  * @param int $contactId Contact id
  *
  */
  function editContact($contactId = 0) {
    $response = [
      "status" => INTERNAL_SERVER_ERROR,
      "message" => "Server Error!! Please try again."
    ];
    $postVars = $_POST;

    if ($contactId == 0) {
      $response = [
        "status" => INVALID_REQUEST,
        "message" => "Contact id is required."
      ];
    } else {
      $isValidRequest = $this->checkPostFields($postVars);

      if (empty($isValidRequest)) {
        $contact = $this->loadModel('Contact');
        $postVars = $this->sanitizeForm($postVars);
        $postVars['contact_full_name'] = $postVars['contact_first_name'] . " " . $postVars['contact_last_name'];
        $contactId = $this->santizeData($contactId);

        $editContact = $contact->updateContact($contactId, $postVars);

        if ($editContact) {
          $response = [
            "status" => SUCCESS_REQUEST,
            "message" => "Contact updated succesfully."
          ];
        }
      } else {
        $response = [
          "status" => INVALID_REQUEST,
          "message" => $isValidRequest
        ];
      }
    }

    echo json_encode($response);
  }

  /**
  * Delete contact details
  *
  * @param int $contactId Contact id
  *
  */
  function removeContact($contactId = 0) {
    $response = [
      "status" => INTERNAL_SERVER_ERROR,
      "message" => "Server Error!! Please try again."
    ];
    $postVars = $_POST;

    if ($contactId == 0) {
      $response = [
        "status" => INVALID_REQUEST,
        "message" => "Contact id is required."
      ];
    } else {
      $contact = $this->loadModel('Contact');
      $contactId = $this->santizeData($contactId);

      $removeContact = $contact->deleteContact($contactId);

      if ($removeContact) {
        $response = [
          "status" => SUCCESS_REQUEST,
          "message" => "Contact deleted succesfully."
        ];
      }
    }

    echo json_encode($response);
  }

  /**
  * Export contact details to json
  *
  */
  function exportToJson() {
    $contact = $this->loadModel('Contact');
    $contacts = $contact->getContact();
    $json = "";

    if (!empty($contacts)) {
      $json = json_encode($contacts);
    }

    $fileHandler = fopen("../data/exports/json/contacts.json", "w");
    fwrite($fileHandler, $json);
    fclose($fileHandler);

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename('../data/exports/json/contacts.json'));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('../data/exports/json/contacts.json'));
    readfile('../data/exports/json/contacts.json');
    exit;
  }

  /**
  * Export contact details to xml
  *
  */
  function exportToXml() {
    $contact = $this->loadModel('Contact');
    $contacts = $contact->getContact();

    if (!empty($contacts)) {
      $xml = new DOMDocument();
      $xml->encoding = 'utf-8';
      $xml->xmlVersion = '1.0';
      $xml->formatOutput = true;
      $root = $xml->createElement('Contacts');

      foreach ($contacts as $contact) {
        $contactNode = $xml->createElement('Contact');
        $id = new DOMAttr('id', $contact['contact_id']);
        $contactNode->setAttributeNode($id);

        foreach ($contact as $node => $value) {
          $childNode = $xml->createElement($node, $value);
          $contactNode->appendChild($childNode);
        }

        $root->appendChild($contactNode);
        $xml->appendChild($root);
      }

      $xml->save("../data/exports/xml/contacts.xml");
    }

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename('../data/exports/xml/contacts.xml'));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('../data/exports/xml/contacts.xml'));
    readfile('../data/exports/xml/contacts.xml');
    exit;
  }

  /**
  * Checks if all required data is submitted in add/edit contact request
  *
  * @param array $data Post data
  *
  * @return string
  */
  private function checkPostFields($data) {
    if (!isset($data['contact_first_name'])) {
      return 'First name is required.';
    }

    if (!isset($data['contact_last_name'])) {
      return 'Last name is required.';
    }

    if (!isset($data['contact_email'])) {
      return 'Email is required.';
    }

    if (!isset($data['contact_street'])) {
      return 'Street is required.';
    }

    if (!isset($data['contact_city_id'])) {
      return 'City is required.';
    }

    if (!isset($data['contact_zip_code'])) {
      return 'Zipcode is required.';
    }

    return '';
  }
}
?>
