#!/usr/bin/env bash
# Create database
mysql -e "CREATE DATABASE psm;"
# Create user
mysql -e "CREATE USER 'psm'@'localhost' IDENTIFIED BY 'psm-dev-password';"
mysql -e "GRANT ALL PRIVILEGES ON psm.* TO 'psm'@'localhost';"
mysql -e "FLUSH PRIVILEGES;";

