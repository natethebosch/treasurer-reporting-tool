
Treasurer Reporting Tool
========================

Setup:
--------

* Edit config.php with the appropriate smtp email information and url root.
* Update data/info.json with appropriate contact email addresses.

### Apache

* No additional setup reqr'd.

### NGINX

* Only allow access to /web-root
* All requests for files that don't exist should be redirected to web-root/index.php