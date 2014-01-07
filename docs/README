 PHP Server Monitor v2.0.1
 http://phpservermon.sourceforge.net
 Copyright (c) 2008-2011 Pepijn Over <ipdope[at]users.sourceforge.net>

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

#################
#               #
# SUMMARY       #
#               #
#################

PHP Server Monitor is a script that checks whether the servers on your list are up
and running on the selected ports.
It comes with a web based user interface where you can add and remove servers or websites from the MySQL database,
and you can manage users for each server with a mobile number and email address.

With version 2.0 there's the support for websites as well. On the "Add server" page, you can choose
whether it's a "service" or a "website":
* service
	A connection will be made to the entered ip or domain, on the given port. This way you can check if certain
	services on your machine are still running. To check your IMAP service for example, enter port 143.

* website
	The previous version only tried to establish a connection to the server on port 80. If you are running multiple
	websites on 1 machine, there was no proper way to check each website for possible errors. Also it was impossible to make
	sure your site was really up and running, all you knew was that the server was still online.
	This function takes care of that.
	You can enter a link to a website (for example http://sourceforge.net/index.php), it will use cURL to open the website and
	check the HTTP status code (see http://en.wikipedia.org/wiki/List_of_HTTP_status_codes for details).
	If the HTTP status code is in the 4xx range, it means an error occured and the website is not accesible to the public.
	In that case the script will return a "status offline", and will start sending out notifications.

Each server has it's own settings regarding notification.
You can choose for email notification or text message (SMS). As of version 2.0, there are 3 gateways
available:
* Mollie - http://www.mollie.nl
* Spryng - http://www.spryng.nl
* Inetworx - http://www.inetworx.ch
For these gateways you need an account with sufficient credits.

If logging is enabled in the configuration, it will log any connection errors, emails and text messages sent.
The latest log records will be displayed on your web interface.
The cron/status.cron.php can be added as a cronjob which will keep the server status up to date.

I'd appreciate any feedback you might have regarding this script. Please leave it on the sourceforge
project page (tracker), or send me an email (see top of file for link).

#################
#               #
# DOWNLOAD      #
#               #
#################

The latest version can be found at http://phpservermon.sourceforge.net


#################
#               #
# REQUIREMENTS  #
#               #
#################

 1. php 5
 2. php packages: cURL
 3. MySQL Database
 4. FTP access


#################
#               #
# INSTALL       #
#               #
#################

By default the PHP Server Monitor does not come with any security methods. After uploading these files to
your public html folder these will be visible to everyone on the web. It is recommended to put a password
on this folder to prevent other people from playing with your tool. An example .htaccess login script can
be found in the example/ dir. To create your own username and password for the .htpasswd file, see
http://www.htaccesstools.com/htpasswd-generator/

 1. Configuration
    Rename the config.inc.php.sample file to config.inc.php, then open the
    config.inc.php file with a plain text editor such as Notepad.
    The first thing to do now in order to get started, is to get your database login information
    right. The information is stored using php's define() function. To change these values correctly, only
    update the second parameter of the function.
    For example:
    define('SM_DB_USER', 'db_user');
    To change your username you should ONLY change the 'db_user' part. Do NOT remove the quotes around
    your username as that will result in an error.

 2. Upload files
 	The next step is to get your files onto your webserver where you can reach them. You can rename the
 	folder of the server monitor without trouble, but if you change the structure please make sure
 	to update the settings in the config.php file

 3. Run install.php
 	Once your database login information is correct, you can run the install.php script located in the
 	root dir. This script will create all the database tables you will need.
 	After running the install.php script you can remove it.

 4. Configure your installation
 	Open the main page of the server monitor, by simply calling index.php. In the menu on the top find "config",
 	it'll open a page where you can change the necessary information for your tool.

 5. [optional] Add a cronjob
 	In order to keep the server monitor up to date, the monitor.php file has to run regulary. If you're running
 	this on a linux machine, the easiest way is to add a cronjob. If it's your own server or you have
 	shell access and permission to open the crontab, locate the "crontab" file
 	(usually in /etc/crontab, but depends on distro). Open the file (vi /etc/crontab), and add the following
 	(change the paths to match your installation directories):

	#server monitor every 15 min
	*/15 * * * * root /usr/bin/php /var/www/html/phpservermon/cron/status.cron.php

	As you can see, this line will run the status.cron.php script every 15 minutes. Change the line to suit your
	needs. If you do not have shell access, ask your webhosting to set it up for you.

 6. Voila!


#################
#               #
# CUSTOMIZING   #
#               #
#################

 1. Language
 	The server monitor uses language files. That means that any regular text you see on the screen can easily be
 	changed without having to digg through the code. These language files are stored in the directory "lang".
 	The language that's being used by the monitor is defined in the config table. If you like
 	you can make changes to the language file or even add a new one.

 	1.1 Changing the email or text message
 		Open the language file that corresponds to the selected language
 		(default is English ("en.lang.php")). Scroll all the way to the bottom until you spot this line:

 			'notifications' => array(

		After that you'll see the lines that hold the notification messages. For example:

			'off_sms' => 'Server \'%LABEL%\' is DOWN: ip=%IP%, port=%PORT%. Error=%ERROR%',

		The first part of this line, 'off_sms', is the name of the notification. You should not change this. The
		second part is the actual message. There are a few variables you can use in your message:
		- %LABEL%				The name of the server
		- %IP%					The ip of the server
		- %PORT%				The port of the server
		- %ERROR%				This one only works for the off_* messages and contains the error returned by the
								monitor

 	1.2 Adding a new language
 		It's not the easiest thing to add a new language to the monitor, but if you can spare a few minutes of your time
 		to send in a translation, it can be added to a future release.
 	 	- Create a new file in the directory "lang" named "mylanguage.lang.php".
 	 	- Copy the contents of the file "en.lang.php" to your new file.
 	 	- Translate the English stuff to your own language.
 	 	- Send a copy to ipdope[at]users.sourceforge.net so I can add it to the next release :)

#################
#               #
# CREDITS       #
#               #
#################

1. classes/phpmailer.class.php - Brent R. Matzelle
2. german translation - Brunbaur Herbert
3. french translation - David Ribeiro
