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