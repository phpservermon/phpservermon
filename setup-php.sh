#!/usr/bin/env bash
# check if vendor dir is existing
DIR="/vagrant/vendor/"
if [ -d "$DIR" ]; then
  # Take action if $DIR exists. #
  echo "vendor dir found, nothing to do..."
else
  echo "vendor dir not found, installing dependencies..."
  cd /vagrant/ && php composer.phar install
fi
