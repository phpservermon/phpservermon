.. _faq:

Frequently Asked Questions
==========================


Users
+++++

What are the differences between the user levels?
-------------------------------------------------

There are 2 user levels available: regular user and administrator.

Administrators:

* Manage servers.
* Manage users.
* Edit global configuration.

Regular users:

* View the status of their assigned servers.
* View the history and logs of their assigned servers.
* Run the updater on their assigned servers.


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
To make sure these requests can be identified, the monitor uses a custom user agent, which you can usually filter out. The user agent of the monitor looks like::

     Mozilla/5.0 (compatible; phpservermon/3.0.1; +http://www.phpservermonitor.org)

What is the log retention period?
---------------------------------

The monitor uses 2 different tables in the database to store history information regarding servers.
The first one is called the "uptime" table. This one keeps full track of the past 7 days, so that detailed information is available (e.g. which checks failed/passed etc).
This allows the monitor to create a detailed graph on the server info page.
In order to prevent the uptime table growing beyond reasonable, after a week the uptime records are archived to a different table.
Archiving means that per day only one record is stored with averages. This still allows some basic statistics, although they are not as detailed as the uptime records.

The retention period tells the monitor how long to keep records in the archive table.

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

Notifications
+++++++++++++

How do I setup Telegram?
------------------------
A few steps are required to get Telegram notifications working.
You need to be an administrator for this part.

1. Go to @botfather (https://t.me/BotFather) and type /start .
2. Type /newbot and give your bot an unique name.
3. Save the API token.

How do I sent Telegram notifications to a person?
-------------------------------------------------
 
1. Go to @cid_bot (https://t.me/cid_bot) and start.
2. Save your chat id.
3. Press the activation button.
4. Go to your chat with the bot and press start of type /start.

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
