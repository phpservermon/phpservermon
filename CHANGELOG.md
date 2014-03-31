# PHP Server Monitor

## Changelog

### v2.2.0 (not yet released, 2014)

 * New module structure (not backwards compatible).
 * Template directory restructured to correspond with module structure.
 * Added user login system with 2 user levels (administrator and regular user).
 * Added warning threshold option (set number of failed checks before server goes offline).
 * Added SMTP support.
 * Adding Bulgarian language file (thanks to Plamen Vasilev).
 * Added user profile page.
 * Added history tracking of server uptime.
 * Added history graphs of server uptime and latency (thanks to Jérôme Cabanis).
 * Status page is now default homepage.
 * Updated French translation.
 * Date and time formats are taken from language file and localized per language (thanks to Jérôme Cabanis).
 * When checking a website, the updater will now follow 302 Location headers.
 * String/pattern search on websites did not work for websites with compression turned on.
 * Switched from mysql_* to PDO.
 * Updated PHPMailer package to v5.2.6.
 * Fixed several XSS vulnerabilities.
 * Project website updated to <http://www.phpservermonitor.org>


### v2.1.0 (released February 8, 2014)

 * PHP 5.3+ required
 * Merged PHP Server Monitor Plus project by Luiz Alberto S. Ribeiro (<https://github.com/madeinnordeste/PHP-Server-Monitor-Plus>).
 * New layout (thanks to twitter bootstrap)
 * New install module.
 * Regex search on website has been added by Paul Feakins.
 * Support for mosms provider by Andreas Ek.
 * Support for Textmarketer provider by Perri Vardy-Mason.
 * Language files are now automatically detected, instead of a hardcoded list.
 * Adding Korean language file (thanks to Ik-Jun).
 * Adding Portuguese / Brazilian language file (thanks to Luiz Alberto S. Ribeiro).
 * Large status page by Michael Greenhill.
 * New config file (see install instructions in README).
 * Cronjob will be prevented from running multiple times at the same time (with a 10 mins timeout).


### v2.0.1 (released October 29, 2011)

 * Adding German language file (thanks to Brunbaur Herbert).
 * Adding French language file (thanks to David Ribeiro).
 * classes/sm/smUpdaterStatus.class.php: the curl option CURLOPT_CUSTOMREQUEST has been changed to CURLOPT_NOBODY.
 * Servers page: auto refresh can be configured at the config page.
 * Servers page: if the server is a website, the "Domain/Ip" field will be a link to the website.
 * New text message gateway: Clickatell.com (thanks to Simon).
 * If cURL is not installed, the install.php script will throw an error.
 * HTTP status codes 5xx will also be treated as error.


### v2.0.0 (released October 19, 2009)

 * Server type ("service" or "website").
 * Different types of notification.
 * New text message gateways.
 * Code rewrite.
 * New layout.
 * Check for updates function.


### v1.0.1 (released September 18, 2008)

 * log.php
 * tpl/log.tpl.html
 * Select order by clause used datetime field after DATE_FORMAT had been performed, resulting in a wrong list of log entries shown.
