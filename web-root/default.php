<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 12:46:00
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 17:30:20
 */

require_once __DIR__ . "/pt.header.php";
?>

<h1>
	Treasurer Reporting Tool
</h1>
<div id="start">
	<input type="button" value="Submit a Receipt" />
</div>
<div id="form">
	<div>
		<input type="button" value="Add Item" id="add-submission" />
	</div>
	<div id="list">
		<div id="list-no-items">Add an item to get started</div>
		<div id="list-template" class="list-item">
			<div class="description">Desciption</div>
			<div class="amount">10.00</div>
			<input type="button" value="remove" class="remove-item" />
		</div>
	</div>

	<div>
		<label>Your Name</label>
		<input type="text" id="submission-submitter" />

		<div class="validation-error" id="sumitter-missing">Please enter your name</div>
	</div>

	<div class="validation-error" id="items-missing">Please add some receipts</div>

	<div>
		<input type="button" value="Submit" id="submit-receipt" />
	</div>
</div>
<div id="item-form">
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
			<input type="button" value="Add Image or PDF" id="add-upload-item" />
			<input type="file" multiple accept="image/*" id="item-receipt" />
		</li>
	</ul>

	<div id="item-missing-fields" class="validation-error">Fill in all the fields</div>

	<input type="button" value="Add" id="add-form-item" />
	<input type="button" value="Cancel" id="cancel-add-form-item" />
</div>

<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="./jquery-ui.min.js"></script>
<script type="text/javascript" src="./script.js"></script>

<?php
require_once __DIR__ . "/pt.footer.php";