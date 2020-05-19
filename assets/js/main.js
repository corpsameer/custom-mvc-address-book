$(document).ready(function(){
  loadContacts();
});

/**
* Gets list of all contacts and loads it in the contacts table
*/
function loadContacts() {
  let table = $('#tblContacts');

  // Get request to get contact list
  $.get("/contacts/getContactDetails", function(response) {
    response = JSON.parse(response);

    if (response.status === 200) {
      let records = [];
      let contacts = response.data;

      for (let i = 0; i < contacts.length; i++) {
        // Create edit and delete button for each contact in the list
        let action = '<a class="btn btn-primary btn-small" href="javascript:editContact(' + contacts[i]['contact_id'] + ')">Edit</a>&nbsp;';
        action += '<a class="btn btn-danger btn-small" href="javascript:deleteContact(' + contacts[i]['contact_id'] + ')">Delete</a>';

        // Create contact rows for table
        records.push({
          series: i + 1,
          contact_first_name: contacts[i]['contact_first_name'],
          contact_last_name: contacts[i]['contact_last_name'],
          contact_full_name: contacts[i]['contact_full_name'],
          contact_email: contacts[i]['contact_email'],
          contact_street: contacts[i]['contact_street'],
          contact_zip_code: contacts[i]['contact_zip_code'],
          city_name: contacts[i]['city_name'],
          action: action,
        });
      }

      // Load data in contact table
      table.bootstrapTable('load', records);
    } else {
      // Show alert if some error occurs
      showAlert("contactPageAlert", "danger", response.message);
    }
  });
}

// Gets details of the contact to be edited and displays in the contact form in contact modal
function editContact(contactId) {
  $.get("/contacts/getContactDetails/"+contactId, function(response) {
    response = JSON.parse(response);

    if (response.status === 200) {
      let contact = response.data[0];

      // Sets data in corresponding form field
      $('#contact_id').val(contact.contact_id);
      $('#contact_first_name').val(contact.contact_first_name);
      $('#contact_last_name').val(contact.contact_last_name);
      $('#contact_email').val(contact.contact_email);
      $('#contact_street').val(contact.contact_street);
      $('#contact_city_id').val(contact.contact_city_id);
      $('#contact_zip_code').val(contact.contact_zip_code);

      // Show contact modal with contact details
      $('#newContact').modal('show');
    } else {
      // Show error message alert in case of error
      showAlert("contactFormAlert", "danger", response.message);
    }
  });
}

// Request to delete contact
function deleteContact(contactId) {
  if (confirm("Are you sure you want to delete this contact?")) {

    // Delete request to delete contact
    $.get("/contacts/removeContact/"+contactId, function(response) {
      response = JSON.parse(response);

      if (response.status === 200) {
        // Show success alert message if contact is deleted successfully
        showAlert("contactPageAlert", "success", response.message);

        // Re-load contacts table with fresh data
        loadContacts();
      } else {
        // Show error alert message if contact is not deleted successfully
        showAlert("contactPageAlert", "danger", response.message);
      }
    });
  }
}

$('#newContactForm').submit(function(e) {
  e.preventDefault();

  // New contact url
  let url = "/contacts/newContact";
  let contactId = $('#contact_id').val();

  // Contact data from form
  let postData = {
    contact_first_name: $('#contact_first_name').val(),
    contact_last_name: $('#contact_last_name').val(),
    contact_email: $('#contact_email').val(),
    contact_street: $('#contact_street').val(),
    contact_city_id: $('#contact_city_id').val(),
    contact_zip_code: $('#contact_zip_code').val()
  };

  // Check if edit request and set url for edit contact details
  if (contactId != 0) {
    url = "/contacts/editContact/" + contactId
  }

  // Post request to add/edit contact data
  $.post(url, postData, function(response) {
    response = JSON.parse(response);

    if (response.status === 200) {
      if (contactId == 0) {
        // Clear form fields if add new contact request
        clearForm("newContactForm");
      }

      // Show success alert if contact is added/updated successfully
      showAlert("contactFormAlert", "success", response.message);

      // Re-load contacts table with fresh data
      loadContacts();
    } else {
      // Show error alert if contact is not added/updated successfully
      showAlert("contactFormAlert", "danger", response.message);
    }
  });
});

// Clear contact form when contact modal is closed
$("#newContact").on("hidden.bs.modal", function (e) {
  clearForm("newContactForm");
});

// Gets alert box id, class and message to be displayed and displays corresponding alert message
function showAlert(alertId, alertClass, alertMessage) {
  $("#"+alertId).addClass("alert-"+alertClass);
  $("#"+alertId+"Head").html(alertClass.toUpperCase()+"!!!");
  $("#"+alertId+"Message").html(alertMessage);

  $("#"+alertId).show();
  setTimeout(function() {
    $("#"+alertId).hide();
    $("#"+alertId).removeClass("alert-"+alertClass);
    $("#"+alertId+"Head").html("");
    $("#"+alertId+"Message").html("");
  },
    5000
  );
}

// Clear form fields
function clearForm(formId) {
  $("#"+formId)
    .find("input,select")
       .val('')
       .end();
}
