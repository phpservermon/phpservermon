.. _developers:

Developers
==========

The code is available from https://github.com/phpservermon/phpservermon.
There is a master branch, which is stable and always reflects the latest release.
The develop branch is used for ongoing development and should not be considered stable.
If you would like to contribute a patch or feature, please fork the develop branch and send a pull request.

Languages
+++++++++

The server monitor uses language files, which are stored in the directory "src/lang".
The name of the language file consists of the language code (ISO 639-1) and the country code (ISO 3166-1), separated by an underscore.
The extension is ".lang.php".

Locales
-------

Each language file should contain a 'locale' key which can be used for formatting dates and times. This 'locale' key must include the locales for different server environments:

* Linux / OS X: same as filename (language code and country code separated by underscore)
* Windows: http://msdn.microsoft.com/en-US/library/39cwe7zf%28v=vs.80%29.aspx

For more information, see http://www.php.net/manual/en/function.setlocale.php

Adding a new language
---------------------

To add a new language, follow these steps:

* Create a new file in the directory "src/lang" named "{locale}.lang.php".
* Copy the contents of the file "en_US.lang.php" to your new file.
* Your new language should now be available on the config page.
* Translate :-)
* Please send a pull request on github (https://github.com/phpservermon/phpservermon) so it can be included in the next release :-)


Getting started
+++++++++++++++

All code related to phpservermon lives in the "psm" namespace, which can be found under "src/psm".

The Router (https://github.com/phpservermon/phpservermon/blob/develop/src/psm/Router.class.php) is used to load the modules.
All modules are registered inside the Router class with a unique ID (see getModules()), and can either be loaded manually ($router->run('mod')), or if no module is given it will attempt to discover the module from the $_GET['mod'] var.
If no valid module or controller is found, it will fall back to the default module.

The module var may exist of 2 parts, separated by an underscore. The first part is the ID of the module, and the second part is the ID of the controller registered in the module.
If no controller ID is found, it will attempt to load the controller with the same ID as the module.

Examples ::

    $router->run('config'); // module ID "config" and controller ID also "config" (same as $router->run('config_config'))
    $router->run('server_status'); // module ID "server" and controller ID "status"

If the user is not logged in and login is required, it will automatically load the user login controller without throwing an error.