#!/bin/sh

cd /vagrant

apt-get install tasksel -y
tasksel install lamp-server
apt-get install php-curl php-xml -y

mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'username'@'localhost' IDENTIFIED BY 'password';"
mysql -e "create database phpservermon;"

rm -rf /var/www/html
ln -s /vagrant/ /var/www/html

runuser -l vagrant -c 'cd /vagrant && php composer.phar install'
runuser -l vagrant -c 'cd /vagrant && php install.php'

touch /vagrant/config.php
chmod 766 /vagrant/config.php
echo "date.timezone = 'UTC'" >> /etc/php/7.2/apache2/php.ini

service apache2 restart

