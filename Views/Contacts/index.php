<?php require 'contactForm.php' ?>
<h1>Contact List</h1>
<hr>
<div class="alert" id="contactPageAlert" style="display: none;">
  <strong id="contactPageAlertHead"></strong> <span id="contactPageAlertMessage"></span>
</div>
<div class="table-responsive">
  <div class="fixed-table-toolbar">
    <div class="pull-left search input-group">
      <div class="btn-group">
        <button class="btn btn-primary btn-small" data-toggle="modal" data-target="#newContact">
          <span class="fa fa-plus"></span>
          Add New Contact
        </button>
        <div class="btn-group ml-10">
          <button type="button" class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown">
            Export <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="/contacts/exportToJson">JSON</a></li>
              <li><a href="/contacts/exportToXml">XML</a></li>
            </ul>
        </div>
      </div>
    </div>
  </div>
  <table class="table table-hover table-bordered data-table"
    id = "tblContacts"
    data-pagination = "true"
    data-toggle = "table"
    data-search = "true"
  >
    <thead>
      <tr>
        <th data-field="series" data-sortable="true">Num</th>
        <th data-field="contact_first_name" data-sortable="true">First Name</th>
        <th data-field="contact_last_name" data-sortable="true">Last Name</th>
        <th data-field="contact_full_name" data-sortable="true">Full Name</th>
        <th data-field="contact_email" data-sortable="true">Email</th>
        <th data-field="contact_street" data-sortable="true">Street</th>
        <th data-field="contact_zip_code" data-sortable="true">Zip Code</th>
        <th data-field="city_name" data-sortable="true">City</th>
        <th data-field="action">Action</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<script src="../assets/js/tables.min.js"></script>
<script src="../assets/js/main.js"></script>
