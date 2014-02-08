# PHP Server Monitor

## SUMMARY

PHP Server Monitor is a script that checks whether the servers on your list are up and running on the selected ports.
It comes with a web based user interface where you can add and remove servers or websites from the MySQL database,
and you can manage users for each server with a mobile number and email address.

With version 2 there's the support for websites as well. On the "Add server" page, you can choose
whether it is a "service" or a "website":

* Service

  A connection will be made to the entered ip or domain, on the given port.
  This way you can check if certain services on your machine are still running.
  To check your IMAP service for example, enter port 143.

* Website

  You can enter a link to a website (for example <http://sourceforge.net/index.php>), it will use cURL to open the website and
  check the HTTP status code (see <http://en.wikipedia.org/wiki/List_of_HTTP_status_codes> for details).
  If the HTTP status code is in the 4xx range, it means an error occurred and the website is not accessible to the public.
  You can also set a regular expression to match certain content on the page itself. If the regular expression returns no matches, the website is considered down.
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

I'd appreciate any feedback you might have regarding this script. Please leave it on the GitHub
project page (tracker), or send me an email (see top of file for link).


## DOWNLOAD

The latest version can be found at <http://phpservermon.neanderthal-technology.com/>.
You can also clone the git repo at <http://github.com/phpservermon/phpservermon> if you want to contribute.


## REQUIREMENTS

 * PHP 5.3+
 * PHP packages: cURL, MySQL
 * MySQL Database


## INSTALL

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


## UPGRADE

### From 2.0

The structure of the project has changed quite a bit since 2.0, but if you have not made any local changes the upgrade is quite easy.
The best thing to do is to replace all your current files with the new release, except for the config.inc.php file.
The config file has actually been renamed since 2.0, but if you keep it there while upgrading the install script will use it to prefill your database information.

 * Replace all files except(!) config.inc.php
 * Navigate to install.php
 * Follow the steps
 * Remove the old config.inc.php file


## Security

By default the PHP Server Monitor does not (yet) come with any security methods. After uploading these files to
your public html folder these will be visible to everyone on the web. It is recommended to put a password
on this folder to prevent other people from playing with your tool. An example .htaccess login script can
be found in the example/ dir. To create your own username and password for the .htpasswd file, see
<http://www.htaccesstools.com/htpasswd-generator/>


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


## CUSTOMIZING

### Language

The server monitor uses language files. That means that any regular text you see on the screen can easily be
changed without having to dig through the code. These language files are stored in the directory "src/lang".
The language that's being used by the monitor is defined in the config table. If you like
you can make changes to the language file or even add a new one.

#### Changing the email or text message

Open the language file that corresponds to the selected language
(default is English ("en.lang.php")). Scroll all the way to the bottom until you spot this line:

     'notifications' => array(

After that you'll see the lines that hold the notification messages. For example:

     'off_sms' => 'Server \'%LABEL%\' is DOWN: ip=%IP%, port=%PORT%. Error=%ERROR%',

The first part of this line, 'off_sms', is the name of the notification. You should not change this.
The second part is the actual message. There are a few variables you can use in your message:

    * %LABEL%				The name of the server
    * %IP%					The ip of the server
    * %PORT%				The port of the server
    * %ERROR%				This one only works for the off_* messages and contains the error returned by the
								monitor

#### Adding a new language

   To add a new language, follow these steps:

   * Create a new file in the directory "src/lang" named "mylanguage.lang.php".
   * Copy the contents of the file "en.lang.php" to your new file.
   * Your new language should now be available on the config page.
   * Translate the English stuff to your own language.
   * Send a copy to pep[at]neanderthal-technology.com so I can add it to the next release :)
   * Or, send me a pull request on github (https://github.com/phpservermon/phpservermon).

## CREDITS

 * Bugfixes & features - Perri Vardy-Mason
 * PHP Mailer - Brent R. Matzelle
 * German translation - Brunbaur Herbert
 * French translation - David Ribeiro
 * Korean translation - Ik-Jun
 * Brazilian translation - Luiz Alberto S. Ribeiro
 * Bootstrap implementation - Luiz Alberto S. Ribeiro
 * Mosms implementation - Andreas Ek
 * Status page - Michael Greenhill

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