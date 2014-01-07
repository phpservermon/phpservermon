<?php

/*
 * PHP Server Monitor v2.0.0
 * Monitor your servers with error notification
 * http://phpservermon.sourceforge.net/
 *
 * Copyright (c) 2008-2009 Pepijn Over (ipdope@users.sourceforge.net)
 *
 * This file is part of PHP Server Monitor.
 * PHP Server Monitor is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP Server Monitor is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP Server Monitor.  If not, see <http://www.gnu.org/licenses/>.
 */

abstract class modCore {
	public $db;
	public $message;
	public $mode;
	public $tpl;
	public $tpl_id;

	function __construct() {
		global $db, $tpl;

		$this->db = ($db) ? $db : new smDatabase();
		$this->tpl = ($tpl) ? $tpl : new smTemplate();
	}

	public function createHTML() {
		$html = $this->tpl->getTemplate($this->tpl_id);
		return $html;
	}
}

?>