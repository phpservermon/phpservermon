.. _install:

Installation
============

Install
+++++++

Upload files
------------

The first step is to upload your files to your webserver where you can reach them.
You can rename the folder of the server monitor without any problems.

Run install.php
---------------

You can now run the install.php script located in the root dir.

The install script will guide you through setting up your configuration file and create the required database tables.
If for some reason you can not generate your configuration file, you can do it manually using the steps below.
Rename the config.php.sample file to config.php, then open the config.php file with a plain text editor such as Notepad.
In this file you need to change the database information, which is stored using php's define() function.
To change these values correctly, only update the second parameter of the function::

     define('PSM_DB_HOST', 'db_host');
     define('PSM_DB_NAME', 'db_name');
     define('PSM_DB_USER', 'db_user');
     define('PSM_DB_PASS', 'db_user_password');

For example: to change your username you should ONLY change the 'db\_user' part.
Do NOT remove the quotes around your username as that will result in an error.
After you have created the config.php, run the install.php again to create the database structure.

Configure your installation
---------------------------

Open the main page of the server monitor, by simply navigating to index.php. In the menu on the top find "Config",
it will open a page where you can change the necessary information for your tool.


Upgrade
+++++++

For a regular upgrade, follow these steps:

* Replace all files except(!) config.php
* Navigate to install.php
* Follow the steps
* Enjoy

From 2.0
--------

The structure of the project has changed quite a bit since 2.0, but if you have not made any local changes the upgrade is quite easy.
The best thing to do is to replace all your current files with the new release, except for the config.inc.php file.
The config file has actually been renamed since 2.0, but if you keep it there while upgrading the install script will use it to prefill your database information.
The rest of the steps are identical to a regular upgrade (see above), except that you can remove the old config.inc.php file afterwards.

From 2.1
--------

One of the new features introduced in 3.0 is a user authentication system. Because the users in previous versions do not have a password, after upgrading you would not be able to login.
For that reason the upgrade script will ask you to create a new account during the upgrade, which you can then use to change the password for the existing accounts.
If, for whatever reason this does not work, the upgrade script automatically changes the username of all existing users to their email addresses, which you could use for the forgot password screen.


Installing from GitHub
++++++++++++++++++++++
If you have downloaded the source from GitHub (and not a pre-built package), the dependencies are not included.
To be able to run an installation from the repo, you need to run the following command to install the dependencies::

     php composer.phar install


Setting up a cronjob
++++++++++++++++++++

In order to keep the server monitor up to date, the status updater has to run regularly.
If you're running this on a linux machine, the easiest way is to add a cronjob.
If it is your own server or you have shell access and permission to open the crontab, locate the "crontab" file
(usually in /etc/crontab, but depends on distro). Open the file (vi /etc/crontab), and add the following
(change the paths to match your installation directories) to run it every 15 minutes::

     */15 * * * * root /usr/bin/php /var/www/html/phpservermon/cron/status.cron.php

As you can see, this line will run the status.cron.php script every 15 minutes. Change the line to suit your needs.
If you do not have shell access, ask your web hosting provider to set it up for you.

Please note that some distros have user-specific crontabs (e.g. Debian). If that is the case, you need to omit the user part::

     */15 * * * * /usr/bin/php /var/www/html/phpservermon/cron/status.cron.php

The update script has been designed to prevent itself from running multiple times. It has a maximum timeout of 10 minutes.
After that the script is assumed dead and the cronjob will run again.
If you want to change the 10 minutes timeout, find the constant "PSM_CRON_TIMEOUT" in src/includes/psmconfig.inc.php.
You can also provide it as an argument (in seconds!). The following example would change to timeout to 10 seconds::

     php status.cron.php --timeout=10

By default, no URLs are generated for notifications created in the cronjob.
To specify the base url to your monitor installation, use the "--uri" argument, like so::

     php status.cron.php --uri="http://www.phpservermonitor.org/mymonitor/"


Troubleshooting
+++++++++++++++

If you have problems setting up or accessing your monitor and do not know why, enable debug mode to turn on error reporting.
To enable debug mode, add the following line to your config.php file::

    define('PSM_DEBUG', true);