
Treasurer Reporting Tool
========================

Quick Start:
-------------
Follow the instructions in [setup](./#setup).

System Properties:
------------------
* A receipt containts the following properties:
	* Submitter
	* Date of purchase
	* Item description
	* Item amount
	* Associated committee
	* Associated budget line item
	* What committee member approved it (and some extra information to validate that)
	* Date of receipt submission
	* Photos of receipt

* Anyone can submit a receipt.
* Mulitple receipts can be sumitted at once.

#####Flow:
* Receipt is uploaded.
* Committee members receive an email asking them to confirm or deny a submitted receipt by using an authenticated link.
* When a committee member confirms or denies a receipt, the treasurer is notified.

#####Email Contents:

* Committee members and treasurer emails contain most of the receipt properties (as above).
* Committee members recieve separate authenticated links to "confirm" or "deny" a receipt.
* "Confirmation" and "Denial" links require the user to confirm their selection after the link is pressed.
* Treasurer receives notification of confirmation or denial and an authenticated link to download all receipts for a year of his/her choosing.

#####Treasurer Properties:
* A treasurer can download all receipts for the year in the folling format:
	* Year
		* Month - Day
			* Submitter
				* Receipt photos
				* CSV spreadsheet form with details filled out for each receipt photo.

* A treasurer's account is kept secure by rotating the authentication link every 4 months.
* A treasure can have the authentication link emailed to his/her-self when the authentication failed message is seen.

#####Misc:
* Web pages are mobile friendly.
* Committee and treasurer emails can be changed by editing data/info.json

Setup:
--------

* Install database schema (see src/db-schema/install.sql). You may manually change the database name from the default 'treasurer-tool'
* Edit config.php with the appropriate smtp email information, url root, encryption and database information.
* Update data/info.json with appropriate contact email addresses.

### Apache

* No additional setup reqr'd.

### NGINX

* Only allow access to /web-root
* All requests for files that don't exist should be redirected to web-root/index.php

Notes: 
---------

See design.mdj to see uml diagrams of design. [Star UML](http://staruml.io)