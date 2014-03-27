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

### 1. Configuration

The install script will guide you through setting up the configuration, but if you want to be ahead of the game, you can do this one first.
Rename the config.php.sample file to config.php, then open the config.php file with a plain text editor such as Notepad.
The first thing to do is to get your database login information right.
The information is stored using php's define() function.
To change these values correctly, only update the second parameter of the function.
For example:

     define('PSM_DB_USER', 'db_user');

To change your username you should ONLY change the 'db\_user' part.
Do NOT remove the quotes around your username as that will result in an error.
If you do not feel comfortable doing this, skip this step and the install script will generate it for you.

### 2. Upload files

The next step is to get your files onto your webserver where you can reach them.
You can rename the folder of the server monitor without trouble.

### 3. Run install.php

You can now run the install.php script located in the root dir.

### 4. Configure your installation

Open the main page of the server monitor, by simply calling index.php. In the menu on the top find "config",
it will open a page where you can change the necessary information for your tool.


## Upgrade

For a regular upgrade, follow these steps:

* Replace all files except(!) config.php
* Navigate to install.php
* Follow the steps
* Enjoy

### From 2.0

The structure of the project has changed quite a bit since 2.0, but if you have not made any local changes the upgrade is quite easy.
The best thing to do is to replace all your current files with the new release, except for the config.inc.php file.
The config file has actually been renamed since 2.0, but if you keep it there while upgrading the install script will use it to prefill your database information.
The rest of the steps are identical to a regular upgrade (see above), except that you can remove the old config.inc.php file afterwards.

### From 2.1

One of the new features introduced in 2.2 is a user authentication system. Because the users in previous versions do not have a password, after upgrading you would not be able to login.
For that reason the upgrade script will ask you to create a new account during the upgrade, which you can then use to change the password for the existing accounts.
If, for whatever reason this does not work, the upgrade script automatically change the username of all existing users to their email addresses, which you could use for the forgot password screen.

## Setting up a cronjob

In order to keep the server monitor up to date, the monitor.php file has to run regularly.
If you're running this on a linux machine, the easiest way is to add a cronjob.
If it is your own server or you have shell access and permission to open the crontab, locate the "crontab" file
(usually in /etc/crontab, but depends on distro). Open the file (vi /etc/crontab), and add the following
(change the paths to match your installation directories) to run it every 15 minutes:

     */15 * * * * root /usr/bin/php /var/www/html/phpservermon/cron/status.cron.php

As you can see, this line will run the status.cron.php script every 15 minutes. Change the line to suit your needs.
If you do not have shell access, ask your web hosting provider to set it up for you.

The update script has been designed to prevent itself from running multiple times. It has a maximum timeout of 10 minutes.
After that the script is assumed dead and the cronjob will run again.


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


## Credits

See CREDITS file.

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
