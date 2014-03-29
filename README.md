# PHP Server Monitor

## Summary

PHP Server Monitor is a script that checks whether your websites and servers are up and running.
It comes with a web based user interface where you can add and remove servers and websites from the MySQL database,
and you can manage users for each server with a mobile number and email address.

There are two different ways to monitor a server:

* Service

  A connection will be made to the entered ip or domain, on the given port.
  This way you can check if certain services on your machine are still running.
  To check your IMAP service for example, enter port 143.

* Website

  You can enter a link to a website, it will then use cURL to open the website and check the HTTP status code.
  If the HTTP status code is in the 4xx range, it means an error occurred and the website is not accessible to the public.
  You can also set a regular expression to match for content on the page itself.
  If the regular expression returns no matches, the website is considered down.
  In both cases the script will return a "status offline", and will start sending out notifications.

Each server has it's own settings regarding notification.
You can choose for email notification or text message (SMS).
The following SMS gateways are currently available:

* Mollie - <http://www.mollie.nl>
* Spryng - <http://www.spryng.nl>
* Inetworx - <http://www.inetworx.ch>
* Clickatell - <https://www.clickatell.com>
* Mosms - <http://www.mosms.com>
* Textmarketer - <http://www.textmarketer.co.uk>

For these gateways you need an account with sufficient credits.

If logging is enabled in the configuration, it will log any connection errors, emails and text messages sent.
The latest log records will be displayed on your web interface.
The cron/status.cron.php can be added as a cronjob which will keep the server status up to date.


## Download

The latest version can be downloaded from <http://www.phpservermonitor.org/>.


## Requirements

 * PHP 5.3+
 * PHP cURL package
 * PHP PDO mysql driver


## Install

See INSTALL.md file.


## Contributing

The code is available from <https://github.com/phpservermon/phpservermon>.
There is a master branch, which is stable and always reflects the latest release.
The develop branch is used for ongoing development and should not be considered stable.
If you would like to contribute a patch or feature, please fork the develop branch and send a pull request.


### Changing the email or text message

Go to the folder "src/lang", open the language file that corresponds to the selected language
(default is English ("en_US.lang.php")). Scroll all the way to the bottom until you spot this line:

     'notifications' => array(

After that you will see the lines that hold the notification messages. For example:

     'off_sms' => 'Server \'%LABEL%\' is DOWN: ip=%IP%, port=%PORT%. Error=%ERROR%',

The first part of this line, 'off_sms', is the name of the notification. You should not change this.
The second part is the actual message. There are a few variables you can use in your message:

    * %LABEL%				The name of the server
    * %IP%					The ip of the server
    * %PORT%				The port of the server
    * %ERROR%				This one only works for the off_* messages and contains the error returned by the monitor


## License

 PHP Server Monitor is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 PHP Server Monitor is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with PHP Server Monitor.  If not, see <http://www.gnu.org/licenses/>.
