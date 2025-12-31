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
 * @since       phpservermon 2.1
 **/

namespace psm\Module;

use psm\Service\Database;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

interface ControllerInterface extends ContainerAwareInterface
{

    public function __construct(Database $db, \Twig\Environment $twig);

    /**
     * Run the controller
     */
    public function run();

    /**
     * Get the minimum required user level for this controller
     * @return int
     */
    public function getMinUserLevelRequired();

    /**
     * Get custom key for CSRF validation
     * @return string
     */
    public function getCSRFKey();

    /**
     * Whether CSRF protection should be enforced for this controller.
     *
     * @return bool
     */
    public function isCsrfProtectionRequired();
}
