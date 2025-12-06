#!/bin/bash
set -euo pipefail

CONFIG_DIR=/var/www/html/config
CONFIG_FILE=/var/www/html/config.php
PERSISTED_CONFIG=$CONFIG_DIR/config.php

mkdir -p "$CONFIG_DIR"

if [ ! -f "$PERSISTED_CONFIG" ]; then
  cat > "$PERSISTED_CONFIG" <<PHP
<?php
define('PSM_DB_PREFIX', getenv('PSM_DB_PREFIX') ?: 'monitor_');
define('PSM_DB_USER', getenv('PSM_DB_USER') ?: 'psm');
define('PSM_DB_PASS', getenv('PSM_DB_PASS') ?: 'psm');
define('PSM_DB_NAME', getenv('PSM_DB_NAME') ?: 'psm');
define('PSM_DB_HOST', getenv('PSM_DB_HOST') ?: 'db');
define('PSM_DB_PORT', getenv('PSM_DB_PORT') ?: '3306');
define('PSM_BASE_URL', getenv('PSM_BASE_URL') ?: '');
define('PSM_WEBCRON_KEY', getenv('PSM_WEBCRON_KEY') ?: '');
define('PSM_WEBCRON_ENABLE_IP_WHITELIST', getenv('PSM_WEBCRON_ENABLE_IP_WHITELIST') ?: 'true');
define('PSM_PUBLIC', filter_var(getenv('PSM_PUBLIC') ?: false, FILTER_VALIDATE_BOOLEAN));
define('PSM_UPTIME_ARCHIVE', getenv('PSM_UPTIME_ARCHIVE') ?: 'monthly');
define('PSM_MAX_GRAPH_RECORDS', getenv('PSM_MAX_GRAPH_RECORDS') ?: 5000);
PHP
  chown www-data:www-data "$PERSISTED_CONFIG"
fi

ln -sf "$PERSISTED_CONFIG" "$CONFIG_FILE"

exec docker-php-entrypoint "$@"
