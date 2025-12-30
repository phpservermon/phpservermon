#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT_DIR"

if [ ! -d vendor ]; then
  echo "Installing PHP dependencies via Composer..."
  "$ROOT_DIR/bin/psm-composer" install
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
