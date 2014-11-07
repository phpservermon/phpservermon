Changelog
=========


v3.1.1 (released November 6, 2014)
----------------------------------

* #130: Added Czech translation.
* #138: Added Polish translation.
* #148: Added Turkish translation.
* #124: Updated Bulgarian translation.
* #132: Updated German translation.
* #134: Updated French translation.
* #144: Updated Brazilian translation.
* #146: Updated Russian translation.
* #147: Updated Spanish translation.
* #128: Added SSL/TLS option for SMTP config.
* #131: Allow URL and timeout to be passed as argument to the cronjob.
* #135: Uptime percentage above 100%.
* #151: Links in install results were stripped automatically from template.


v3.1.0 (released August 7, 2014)
--------------------------------

Features:

* #52: Uptime percentage per server for the last week.
* #101: Pushover.net support.
* #54: Improved phone/tablet compatibility.
* #75: Test mode for email and SMS settings.
* #86: Different design styles on status page (list, table).
* #82: Added Danish translation.
* #103: Added Russian translation.
* #109: Custom time-out per server.
* #119: Log and archive retention period.
* #110: Support for SMSGlobal SMS gateway <https://www.smsglobal.com/>.
* #82: Support for Danish SMS provider Smsit <http://www.smsit.dk/>

Bugs:

* #50: Validation on servers page.
* #62: Replace javascript confirm dialogs with Bootstrap modal dialogs.
* #66: Unable to add users with MySQL in strict mode.
* #83: Invalid redirect after switching languages and logging in.
* #105: Fixing check for websites with unverified SSL certificates.
* #107: Fixing update job for Synology DSM Task Scheduler.
* #108: URLs on Windows contained both back- and forward slashes.
* #111: Generated urls for non-default ports included the port twice.
* #28: Permission denied page.
* #53: User selection on server edit page.
* #115: Warning on server page when notifications are disabled.
* #117: Template service has been replaced by Twig.
* Composer added for dependencies.

v3.0.1 (released April 12, 2014)
--------------------------------

* #56: Minimum PHP version is PHP 5.3.7 (not PHP 5.3.0).
* #58: Server order on users page now matches the order on servers page.
* #59: Warning threshold ignored for notification trigger.
* #57: Added Chinese translation.
* #60: Added Italian translation.
* #61: Added Spanish translation.
* Sphinx is now used for documentation <http://sphinx.pocoo.org/>.


v3.0.0 (released April 6, 2014)
-------------------------------

* New module structure (not backwards compatible).
* Added user login system with 2 user levels (administrator and regular user).
* Added warning threshold option (set number of failed checks before server goes offline).
* Added SMTP support.
* Adding Bulgarian language file.
* Added history tracking of server uptime.
* Added history graphs of server uptime and latency.
* Added user profile page.
* Status page is now default homepage.
* Updated translations.
* Date and time formats are taken from language file and localized per language.
* When checking a website, the updater will now follow 302 Location headers.
* String/pattern search on websites did not work for websites with compression turned on.
* The monitor now uses a custom user agent so it can be identified in access logs (Mozilla/5.0 (compatible; phpservermon/version; +http://www.phpservermonitor.org)).
* Improved mobile compatibility.
* Template directory restructured to correspond with module structure.
* Switched from mysql_* to PDO.
* Updated PHPMailer package to v5.2.6.
* Fixed several XSS vulnerabilities.
* Project website updated to <http://www.phpservermonitor.org>


v2.1.0 (released February 8, 2014)
----------------------------------

* PHP 5.3+ required
* Merged PHP Server Monitor Plus project by Luiz Alberto S. Ribeiro (<https://github.com/madeinnordeste/PHP-Server-Monitor-Plus>).
* New layout
* New install module.
* Regex search on website has been added.
* Support for mosms provider.
* Support for Textmarketer provider.
* Language files are now automatically detected, instead of a hardcoded list.
* Adding Korean language file.
* Adding Portuguese / Brazilian language file.
* Large status page.
* New config file (see install instructions in README).
* Cronjob will be prevented from running multiple times at the same time (with a 10 mins timeout).


v2.0.1 (released October 29, 2011)
----------------------------------

* Adding German language file.
* Adding French language file.
* classes/sm/smUpdaterStatus.class.php: the curl option CURLOPT_CUSTOMREQUEST has been changed to CURLOPT_NOBODY.
* Servers page: auto refresh can be configured at the config page.
* Servers page: if the server is a website, the "Domain/Ip" field will be a link to the website.
* New text message gateway: Clickatell.com.
* If cURL is not installed, the install.php script will throw an error.
* HTTP status codes 5xx will also be treated as error.


v2.0.0 (released October 19, 2009)
----------------------------------

* Server type ("service" or "website").
* Different types of notification.
* New text message gateways.
* Code rewrite.
* New layout.
* Check for updates function.


v1.0.1 (released September 18, 2008)
------------------------------------

* log.php
* tpl/log.tpl.html
* Select order by clause used datetime field after DATE_FORMAT had been performed, resulting in a wrong list of log entries shown.


v1.0.0 (released July 16, 2008)
-------------------------------

* Initial release
