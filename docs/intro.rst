.. _intro:

Introduction
============

Summary
+++++++

PHP Server Monitor is a script that checks whether your websites and servers are up and running.
It comes with a web based user interface where you can manage your services and websites,
and you can manage users for each server with a mobile number and email address.


Features
++++++++

* Monitor services and websites (see below).
* Email, SMS and Pushover notifications.
* View history graphs of uptime and latency.
* User authentication with 2 levels (administrator and regular user).
* Logs of connection errors, outgoing emails and text messages.
* Easy cronjob implementation to automatically check your servers.


Servers
-------
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


Notifications
-------------
Each server has its own settings regarding notification.
You can choose for email, text message (SMS) and Pushover.net notifications.
The following SMS gateways are currently available:

* Clickatell - <https://www.clickatell.com>
* Inetworx - <http://www.inetworx.ch>
* Mollie - <http://www.mollie.nl>
* Mosms - <http://www.mosms.com>
* Smsglobal - <http://smsglobal.com/>
* SMSit - <http://www.smsit.dk/>
* Spryng - <http://www.spryng.nl>
* Textmarketer - <http://www.textmarketer.co.uk>

Please note: for these gateways you will need an account with sufficient credits.


Download
++++++++

The latest version can be downloaded from http://www.phpservermonitor.org/.