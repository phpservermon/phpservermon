#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT_DIR"

if [ ! -f composer.phar ]; then
  echo "composer.phar not found. Downloading..."
  EXPECTED_SIGNATURE=$(wget -q -O - https://composer.github.io/installer.sig)
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');")
  if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then
    echo 'ERROR: Invalid composer installer signature' >&2
    rm composer-setup.php
    exit 1
  fi
  php composer-setup.php --quiet
  rm composer-setup.php
fi

if [ ! -d vendor ]; then
  echo "Installing PHP dependencies via composer.phar..."
  php composer.phar install
else
  echo "Vendor directory already present, skipping composer install."
fi

if [ ! -f config.php ]; then
  echo "Creating config.php from config.php.sample..."
  cp config.php.sample config.php
  printf "\n# Default development credentials: DB psm/psm-dev-password on localhost\n" >> config.php
else
  echo "config.php already exists, leaving it untouched."
fi

echo "Done. Configure your database credentials in config.php if needed."
