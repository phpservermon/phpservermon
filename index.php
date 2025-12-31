<?php

/**
 * REMITK MONITORING
 * Monitor your servers and websites.
 *
 * This file is part of REMITK MONITORING.
 * REMITK MONITORING is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * REMITK MONITORING is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with REMITK MONITORING.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     phpservermon
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

require __DIR__ . '/src/bootstrap.php';

psm_no_cache();

if (isset($_GET["logout"])) {
    $router->getService('user')->doLogout();
    // logged out, redirect to login
    header('Location: ' . psm_build_url());
    die();
}

$mod = psm_GET('mod', PSM_MODULE_DEFAULT);

try {
    $router->run($mod);
} catch (\InvalidArgumentException $e) {
    // invalid module, try the default one
    // it that somehow also doesnt exist, we have a bit of an issue
    // and we really have no reason catch it
    $router->run(PSM_MODULE_DEFAULT);
}
