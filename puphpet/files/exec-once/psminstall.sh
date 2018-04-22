#!/bin/bash
cd /var/www/default/psm && make install
echo "<?php \
define('PSM_DB_PREFIX', 'monitor_'); \
define('PSM_DB_USER', 'psm'); \
define('PSM_DB_PASS', 'psm'); \
define('PSM_DB_NAME', 'psm'); \
define('PSM_DB_HOST', 'localhost'); \
define('PSM_DB_PORT', '3306'); \
?>" > /var/www/default/psm/config.php

echo "<?php \
header('Location: /psm/index.php'); \
?>" > /var/www/default/index.php
