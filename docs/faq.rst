.. _faq:

Frequently Asked Questions
==========================


Users
+++++

What are the differences between the user levels?
-------------------------------------------------

There are 3 user levels available: anonymous, regular user and administrator.

Administrators:

* Manage servers.
* Manage users.
* Edit global configuration.

Regular users:

* View the status of their assigned servers.
* View the history and logs of their assigned servers.
* Run the updater on their assigned servers.

Anonymous:
Only meant for user '__PUBLIC__' and can't be assigned to any other user.

* View the status of their assigned servers without password.

I removed user '__PUBLIC__', what now?
--------------------------------------

* Go to users -> create new user.
* Set the username to '__PUBLIC__', level to 'anonymous' and the rest is up to you. 

Servers
+++++++

What is the difference between a service and a website?
-------------------------------------------------------

For websites, the monitor attempts to open a regular web page, just like you do in your browser.
It will attempt to retrieve its contents, and also check the HTTP status code (for example "404 not found" will cause an error).
You can then even add a check to make sure the content of the website includes a certain string or matches a certain regular expression.
Please note, it only retrieves the contents and does not execute any Javascript. Your search pattern will not work if it depends on Javascript being executed.

For services, the monitor only attempts to connect to the IP address and specified port to check whether the server is listening on that port.
For example, if you are running a webserver it will usually listen on port 80 for incoming connections.
So if the monitor is able to connect to the server on port 80, you know the webserver is running and accepting connections.
It does not, however, mean that your website is available to your users, because it might have PHP errors or database problems.
This can be monitored using the website type with a pattern search as described above.

Are requests made by the monitor included in my website statistics?
-------------------------------------------------------------------

There are two different ways to gather statistics.
One way is to include a piece of Javascript in your HTML, e.g. for Google Analytics and Piwik.
The other way is to parse the access logs created by your webserver software, which does not require any changes to your code, and is done by tools like Awstats.

When using tools such as Google Analytics, the monitor requests will not show up in your statistics, because the monitor does not execute any Javascript.
Tools that parse your raw access logs like Awstats, will include the requests made by the monitor.
To make sure these requests can be identified, the monitor uses a custom user agent, which you can usually filter out. The user agent can be modified in the config section, but bij default looks like::

     Mozilla/5.0 (compatible; phpservermon/3.0.1; +http://www.phpservermonitor.org)

What is the log retention period?
---------------------------------

The monitor uses 2 different tables in the database to store history information regarding servers.
The first one is called the "uptime" table. This one keeps full track of the past 7 days, so that detailed information is available (e.g. which checks failed/passed etc).
This allows the monitor to create a detailed graph on the server info page.
In order to prevent the uptime table growing beyond reasonable, after a week the uptime records are archived to a different table.
Archiving means that per day only one record is stored with averages. This still allows some basic statistics, although they are not as detailed as the uptime records.

The retention period tells the monitor how long to keep records in the archive table.

How to disable caching?
------------------------

Caching can be stopt by using a unique url. Place `%cachebuster%` in the url,
this will be replaced with the value of time().
Example: https://example.com?%cachebuster% will run as https://example.com?571768757.

Configuration
+++++++++++++

How can I change the text of the email / SMS?
---------------------------------------------

Go to the folder "src/lang", open the language file that corresponds to the selected language
(default is English ("en_US.lang.php")). Scroll all the way to the bottom until you spot this line::

     'notifications' => array(

After that you will see the lines that hold the notification messages. For example::

     'off_sms' => 'Server \'%LABEL%\' is DOWN: ip=%IP%, port=%PORT%. Error=%ERROR%',

The first part of this line, 'off_sms', is the name of the notification. You should not change this.
The second part is the actual message. There are a few variables you can use in your message:

* %LABEL% - The name of the server
* %IP% - The ip of the server
* %PORT% - The port of the server
* %ERROR% - This one only works for the off_* messages and contains the error returned by the monitor

After upgrading, my email stopped working.
------------------------------------------

Run 'php composer.phar update' and you should be good to go!

Setting up a public page.
-------------------------

1. Set PSM_PUBLIC to true in config.php.
2. If not yet existing, create a user with username '__PUBLIC__'. See Users -> "I removed user '__PUBLIC__', what now?" for help.
3. Add servers to user '__PUBLIC__'.
4. Go to /public.php.

Notifications
+++++++++++++

I'm not recieving a notification after my server went down.
-----------------------------------------------------------

1. Check if you have setup the noticication method correctly on the config tab.
2. Check if you have added the user to the server you want to monitor. This can be found under permissions while editting the server.
3. Check if you have enabled the notification method for the server. This can be changed on the server edit page.

How do I setup Telegram?
------------------------
A few steps are required to get Telegram notifications working.
You need to be an administrator for this part.

1. Go to @botfather (https://t.me/BotFather) and type /start .
2. Type /newbot and give your bot an unique name.
3. Save the API token.
4. Login to PhpServerMonitor dashboard > config > Telegram > put your api token into Telegram API Token's column.

How do I sent Telegram notifications to a person?
-------------------------------------------------
 
1. Go to @cid_bot (https://t.me/cid_bot) and start.
2. Save your chat id.
3. Login to PhpServerMonitor dashboard then open user profile page, then put your chat id into Telegram chat id's column.
4. Press save then activate Telegram notifications button.
5. Go to your chat with the bot and press start of type /start.

How do I sent Telegram notifications to a group?
------------------------------------------------  

1. Add @cid_bot (https://t.me/cid_bot) to the group.
2. Save the chat id (including the -).
3. Remove @cid_bot from the group.
4. Add your bot to the group.

How do I sent Telegram notifications to a channel?
--------------------------------------------------

1. Create a public channel.
2. Add the bot as an administator to the channel.
3. Save chat id as: @channelname.

What is the username of my bot?
-------------------------------

1. Go to profile on the monitor.
2. Press activate.
3. A button will appear, this will direct you to your Telegram bot.

How do I setup Jabber notifications from Google account?
--------------------------------------------------------
A few steps are required to get Jabber notifications working for Google account.
You need to be an administrator for this part.

1. Go into you Google Account Security settings (https://myaccount.google.com/security).
2. Check that you have two factor auth enabled. If not, activate it.
3. Add new app password - copy it.
4. Login to PhpServerMonitor dashboard > config > Jabber and use password from step 3 with your Google account in PhpServerMonitor jabber settings.
5. As host use `talk.google.com`.
6. As username use your whole Google account (for example `example@google.com`).
7. As port use `5223` (really, not typo error ...).
