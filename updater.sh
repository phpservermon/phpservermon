#!/bin/bash
#
# phpservermonitor updater
# Developed by petrk94 - https://github.com/petrk94
# Worked on by fr32k - https://github.com/fr32k
#
# requirements 
# PHP
# cURL
# grep
# unzip
#
# used code:
# cURL github API url: https://stackoverflow.com/questions/24987542/is-there-a-link-to-github-for-downloading-a-file-in-the-latest-release-of-a-repo

echo .......... PHPSERVERMON UPDATER ..........

# Check requirements
# unzip
if ! type -p unzip; then
    echo "unzip not installed. exit"
    exit 1
fi

# grep
if ! type -p grep; then
    echo "grep not installed. exit"
    exit 1
fi

# cURL
if ! type -p curl; then
    echo "cURL not installed. exit"
    exit 1
fi

# check if updater is executed from within the phpservermon directory
if [ ! -f ./updater.sh ]; then 
    echo STOPPED: don\'t execute the updater from another directory!
    exit 1
else
    echo Start updating
fi

# get latest version
version=$(curl -s https://api.github.com/repos/phpservermon/phpservermon/releases/latest | grep browser_download_url | cut -d '/' -f 8)
echo Downloading latest Version of PHPServerMonitor \($version\)

# get download URL
downloadfile=$(curl -s https://api.github.com/repos/phpservermon/phpservermon/releases/latest | grep "zipball" | cut -d '"' -f 4)

# download latest release
curl -so update.zip.keep $downloadfile

echo Save config.php 
mv config.php config.php.keep
echo done!

# remove old files except config.php.keep
echo Removing old files...
find . -type f ! -iname "*.keep" -delete
rm -rf cron/ docs/ puphpet/ src/ static/

echo OK

# unzip update file
mv update.zip.keep update.zip
unzip update.zip

# move all files and directories from new created phpservermon directory, to the directory above with the native phpservermon installation
mv phpservermon*/* .
# remove phpservermon directory
rm -rf phpservermon*
# remove zip file
rm update.zip
# restore original config.php back from config.php.keep
mv config.php.keep config.php

# run php composer.phar install or update
if [ -d "vendor" ]; then
    php composer.phar update
else
    php composer.phar install
fi

echo Update finished!
echo Please finish the installation in your browser.
