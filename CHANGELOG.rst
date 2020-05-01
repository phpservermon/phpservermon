Changelog
=========


Not yet released
----------------
\-

v3.5.0 (released May 1, 2020)
-----------------------------

* See https://github.com/phpservermon/phpservermon/compare/v3.4.5...v3.5.0

v3.4.5 (released September 30, 2019)
------------------------------------

* a8eaedc8: Fixed undefined index last_output.

v3.4.4 (released September 26, 2019)
------------------------------------

* 932c695f: Fixed selected view in graph.
* 6aca2e10: Fixed auto refresh with wrong layout.
* 9f3e140b: Changed static file path to new path.
* 29adce26: Removed old static directory.

v3.4.3 (released September 26, 2019)
------------------------------------

* b399327c: Fixed week/month/year graph.
* 4ebe934b: Added timeout to services.
* 8342a979: Changed auto-refresh_help to uniform name.
* 5d668b78: Fixed auto-refresh.
* #777: Fix pushover_status checkbox population from config.

v3.4.2 (released September 24, 2019)
------------------------------------

* 1b0d86b: Fixed wrong upgrade query and added forgotten version_compare.

v3.4.1 (released September 17, 2019)
------------------------------------

* #733: Added catalan ca_ES.lang.php.
* 6c1763e: Updated table style.
* #770: Changed last_output column to TEXT and restricted to 5000 characters.

v3.4.0 (released September 17, 2019)
------------------------------------

* #741: Truncate server output.
* accd556: Fixed typo in es_ES.lang.php.
* #747: Added XML to requirements.
* #740: Update es_ES.lang.php.
* #752: Update fr_FR.lang.php.
* 86c0a58: Added server_id as id (fixes #738).
* be9e3f7: Composer update.
* 8cc8a0d: Updated wget to curl.
* #662: Updated Japanese Translations.
* #697: Adding verbosity for cURL.
* #695: Allow HTTP/2 status responses.
* #703: Update es_ES.lang.php.
* 5b0fba6: Add button when there are no servers.
* 5511cd5: Added faq for #719.
* fcd12d9: Updated bootstrap to 4.3.1.
* 6ca3615: Added missing field to email config.
* 3e1b912: Updated Bootstrap-select to v1.13.10.
* cba09ed: Manifest, Sw.js - Fixed path to files.
* f70dacb: Added sw.js and manifest.
* 59be9f2: Added beter support for use without Javascript.
* 9915a11: Improved accessibility.
* 0025af2: Updated Bootstrap-select to v1.13.9.
* fea3289: Added missing offline duration.
* 560dc8a: Makefile - Adding an input to choose macOS as the current OS.
* 5e5281d: Fixing #665.
* 9cdafc9: Updated useragent to Github URL.
* cf2f6b0: Changed database column to TEXT.
* 6c14709: Updated default template (fixing #685).
* 5424976: Fixed PHPMailer 6.0.5 Vulnerability (resolving #680).
* 2c6ef08: Added noopener and updated download link to Github releases.
* #656: Downgraded symfony/filesystem to ~3.4 (PHP 5.5.9 compatible) and added 7.0.8 as minimal PHP7 version.
* #620: Added updater.sh shell script.
* #653: Fixes wrong default type in upgrade/install query.
* #642: Added post field as addition to #631.
* #644: Fixed urlencoding in Nexmo message
* #639: Added combined notifications.
* #626: Added redirect check.
* #627: Latest server output, error and output during a failure will be saved and are shown on the server page.
* #631: Added option to specify the request method.
* #628: Added the option to mark specific HTTP status codes as online.
* #640: Removed () after last offline value when the last offline duration is unknown.
* #637: Added php extensions to composer required list, spelling fixes in changelog and composer update.
* #635: Changed server order on ?&mod=user&action=edit&id=x.
* #634: Changed ' to " in sql query, both were used.
* #629: Fix bug that made it impossible to check rdp:// and fixed port update.
* b49659f: Added question to notification faq about not receiving notifications.
* ef28908: Indentation fix.
* #605: Added Norwegian language.
* f6173d4: Added license to composer.json file.

v3.3.1 (released August 10, 2018)
---------------------------------

* #403: Removed default mysql port settings from files and left empty values.
* 5e61d89: Defined $encrypted_password.
* ce8182e: Updated composer.lock.
* 51ef755: Removed last_offline_duration = "" bug.
* 6534749: Added last offline duration to all translations.
* e4bade3: Updated PHPMailer namespace.
* d2dda8a: Removed duplicate from Russian translation.
* #613: Updated Russian translation.
* f21f3db: Typo fix, removed unused code & updated documentation.
* 476c59e: Update required PHP version to 5.5.9.
* 1c984b3: Update documentation, added some small changes.
* eac8ebc: Fixed sms error check.
* e2c424e: Spacing, indentation and braces.
* a05d36d: Fixed typos & removed unused code.
* 3023c83: Changed die() to trigger_error().
* a96e1e5: Removed eval(), redone get & load language functions.
* b0ea7eb: Added forgotten translation.
* 92e8312: Removed unused code.
* fc84c06: Added cronjob over web to documentation. Changed HTMl error to 403.
* 93b324f: Security update symfony/http-foundation.
* dd56e29: Update composer.phar to new version.
* b98a4af: Typo fix.

v3.3.0 (released May 30, 2018)
------------------------------

* 57f4c36: Added support for the following SMS gateways: Plivo, SolutionsInfini, Callr and GatewayAPI.
* c3751e7: Moved Clickatell api key to password field.
* #590: Rollback Twig version update to work with PHP5.
* #589: Enlarge select pattern_online width.
* 3c55a35: Allow ping by hostname.
* #579: Added support for "site online when pattern not found".
* #587: Added __MACOSX/ to .gitignore.
* a496874, 62254a5 and 57f4c36: Rewritten global and gateway specific SMS gateway functions.
* 8ca259d: Updated list of available SMS gateways.
* d64f27f: Add CM Telecom bulk SMS gateway.
* 0580e75: Added last offline and the duration of the last outage.
* 3a005f2: Fixing #580 removed results block.
* 79742fe: Fixed ping error: Failed to parse address &quot;8.8.8.8&quot;.
* fc4ffd6: Added Twilio and Telegram to notification list and changed URL to download the latest release.
* #571: Update several dependencies.
* #569: Added support for Twilio SMS gateway.
* a80452d: Added Telegram and Pushover to inline documentation.
* 526c252: Added noopener to external link.
* 64b4d60: Added activation process for Telegram notifications.
* 67632ab: Added Telegram notifications to the documentation.
* 7059ac6: Defined latency for new added servers.
* 11a021e: Fixed indentation fail #515.
* #550: Fix urlencode bug when sending SMS using FreeMobileSMS.
* #541: Fix method declaration error in PHP7.2.
* #515: Run archive and cleanup per server to reduce memory use.
* #516: Fixed #500 ping latency.
* 2471767: Fixed pre installed server query.

v3.2.2 (released March 27, 2018)
--------------------------------

* #554: Implemented Telegram notifications.
* #505: Added button to clear the logs.
* #436: Nexmo.class.php updates to Nexmo.php.
* #350: Removed utf8_decode.
* Updated credits.
* #535: Updated Japanese translation.
* #502: Fixed database population bug during installation.
* #512: Added username validation during installation and added the dot (.) to allowed characters.
* #475: Added Japanese translation.

v3.2.1 (released March 27, 2018)
--------------------------------

* #343: Added optional header value check.
* #433: Changed baseurl repoforgeextras.
* #432: Changed baseurl repoforge.
* #437: Octopush.class.php updates to Octopush.php.
* #435: Added Nexmo SMS to list in config.tpl.html.
* #464: Updated attributes pushover_key and pushover_device in update.tpl.html.
* #454: Updated HistoryGraph.php timestamp to number_format.

v3.2.0 (released April 15, 2017)
--------------------------------

* #170: Implement Nexmo SMS.
* #161: Added Swedish translation.
* #185: Added Estonian translation.
* #210: Added Finnish translation.
* #201: Added Persian translation.
* #195: Updated Spanish translation.
* #169: Increased server ip char limit to 500.
* #164: Added support for FreeVoipDeal SMS gateway <http://www.freevoipdeal.com>.
* #181: Added blank index files to prevent directory listing.
* #237: Adding CSRF protection.
* #287: Default language - English.
* #286: Add popular ports drop down.
* #269: Added Slovenian language.
* #96:  Authentication for website checks.


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
