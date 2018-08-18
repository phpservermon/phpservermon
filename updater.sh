#phpservermonitor updater
# Developed by petrk94 - https://github.com/petrk94
#
# requirements 
# PHP
# cURL
# grep
# unzip
#
# used code:
# cURL github API url: https://stackoverflow.com/questions/24987542/is-there-a-link-to-github-for-downloading-a-file-in-the-latest-release-of-a-repo

version=$(curl -s https://api.github.com/repos/phpservermon/phpservermon/releases/latest | grep browser_download_url | cut -d '/' -f 8)
echo Downloading latest Version of PHPServerMonitor \($version\)

downloadfile=$(curl -s https://api.github.com/repos/phpservermon/phpservermon/releases/latest | grep "zipball" | cut -d '"' -f 4)
wget -O update.zip.keep $downloadfile
if ! [ $? -eq 0 ]
then
   echo "wget not installed"
   exit
fi

echo Save config.php 
mv config.php config.php.keep
echo done!

# remove old files except config.php.keep
echo Removing old files...
find . -type f ! -iname "*.keep" -delete
rm -rf cron/ docs/ puphpet/ src/ static/ vendor/
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

# run php composer.phar install
php composer.phar install

echo Update finished!
echo Please finish the installation in your browser.
