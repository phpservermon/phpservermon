.. _faq:

Frequently Asked Questions
==========================

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
