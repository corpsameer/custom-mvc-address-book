<div id="newContact" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Contact Form</h4>
      </div>
      <div class="modal-body">
        <div class="alert" id="contactFormAlert" style="display: none;">
          <strong id="contactFormAlertHead"></strong> <span id="contactFormAlertMessage"></span>
        </div>
        <form id="newContactForm">
          <input type="hidden" id="contact_id" name="contact_id" value="0" />
          <div class="form-group">
            <label for="contact_first_name">First name</label>
            <input type="text" class="form-control" name="contact_first_name" id="contact_first_name" placeholder="John" required />
          </div>
          <div class="form-group">
            <label for="contact_last_name">Last name</label>
            <input type="text" class="form-control" name="contact_last_name" id="contact_last_name" placeholder="Doe" required />
          </div>
          <div class="form-group">
            <label for="contact_email">Email</label>
            <input type="email" class="form-control" name="contact_email" id="contact_email" placeholder="johndoe@gmail.com" required />
          </div>
          <div class="form-group">
            <label for="contact_street">Street</label>
            <input type="text" class="form-control" name="contact_street" id="contact_street" placeholder="Dalal street" required />
          </div>
          <div class="form-group">
            <label for="contact_city_id">City</label>
            <select class="form-control" name="contact_city_id" id="contact_city_id" placeholder="Select city" required>
              <option value="">-- Select city --</option>
              <?php foreach ($cities as $city): ?>
                <option value=<?= $city['city_id']; ?>><?= $city['city_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="contact_zip_code">Zipcode</label>
            <input type="text" class="form-control" name="contact_zip_code" id="contact_zip_code" placeholder="112233" required />
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success">Add Contact</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
