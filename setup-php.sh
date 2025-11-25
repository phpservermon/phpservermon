#!/usr/bin/env bash
# check if vendor dir is existing
DIR="/vagrant/vendor/"
if [ -d "$DIR" ]; then
  # Take action if $DIR exists. #
  echo "vendor dir found, nothing to do..."
else
  echo "vendor dir not found, installing dependencies..."
  if command -v composer >/dev/null 2>&1; then
    COMPOSER_CMD="composer"
  else
    COMPOSER_CMD="php composer.phar"
  fi

  cd /vagrant/ && ${COMPOSER_CMD} install
fi
