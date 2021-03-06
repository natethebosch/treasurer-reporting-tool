<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 12:46:00
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 13:22:49
 */

require_once __DIR__ . "/pt.header.php";
?>

<div id="start">
	<input type="button" value="Submit a Receipt" />
</div>
<div id="form">
	<div id="form-header">
		<input type="button" value="Add Item" id="add-submission" />
	</div>
	<div id="form-list">
		<div id="list-no-items">Add an item to get started</div>
		<div id="list-template" class="list-item">
			<div class="description">Desciption</div>
			<div class="amount">10.00</div>
			<input type="button" value="remove" class="remove-item" />
		</div>
	</div>

	<div id="form-personal-info">
		<label>Your Name</label>
		<input type="text" id="submission-submitter" />

		<div class="validation-error" id="sumitter-missing">Please enter your name</div>
	</div>

	<div class="validation-error" id="items-missing">Please add some receipts</div>

	<div>
		<input type="button" value="Submit" id="submit-receipt" />
	</div>
</div>
<div id="item-form" class="msg-box">
	<h2>Add Item</h2>
	<ul>
		<li>
			<label>Amount</label>
			<input type="number" id="item-amount" />
		</li>
		<li>
			<label>Description</label>
			<textarea id="item-description"></textarea>
		</li>
		<li>
			<label>Date of Purchase</label>
			<input type="text" id="item-purchase-date" />
		</li>
		<li>
			<label>Committee</label>

			<select id="item-committee">
				<option>Property</option>
				<option>Fundraising</option>
				<option>Library</option>
				<option>Administration</option>
				<option>Finance</option>
				<option>Staffing</option>
				<option>Principle</option>
			</select>
		</li>
		<li>
			<label>Line Item</label>

			<select id="item-line-item">
				<option>Admin</option>
				<option>Curriculum</option>
				<option>Facility Upgrades</option>
				<option>Library</option>
				<option>Repairs and Maintenance</option>
				<option>School Supplies</option>
				<option>Sports Equipement and Supplies</option>
				<option>Art Supplies</option>
			</select>
		</li>
		<li>
			<label>Receipt</label>
			<ul id="receipt-photos"></ul>
			<input type="button" value="Add Image" id="add-upload-item" />
			<input type="file" multiple accept="image/*" id="item-receipt" />
		</li>
	</ul>

	<div id="item-missing-fields" class="validation-error">Fill in all the fields</div>

	<input type="button" value="Add" id="add-form-item" />
	<input type="button" value="Cancel" id="cancel-add-form-item" />
</div>
<div id="submit-processing" class="msg-box">
	<h2>Uploading your information</h2>
	<p>Progress: 0%</p>
</div>
<div id="submit-success" class="msg-box">
	<h2>Your information has been submitted.</h2>
	<p>
		You can close this window.
	</p>
</div>

<div id="submit-error" class="msg-box">
	<h2>Error</h2>
	<p id="submit-error-msg"></p>
	<p>Please contact your administrator or refresh the page and try again</p>
</div>

<script src="./jquery-2.2.3.min.js"></script>
<script src="./jquery-ui.min.js"></script>
<script type="text/javascript" src="./script.js"></script>

<?php
require_once __DIR__ . "/pt.footer.php";