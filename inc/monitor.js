/**
 * PHP Server Monitor
 * Monitor your servers and websites.
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
 *
 * @package     phpservermon
 * @author      Pepijn Over <pep@neanderthal-technology.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://phpservermon.neanderthal-technology.com/
 **/

function sm_delete(id, type) {
        var del = confirm("Are you sure you want to delete this record?");
        if (del == true) {
                var loc = 'index.php?delete=' + id + '&type=' + type;
                window.location = loc;
        }
}
function sm_highlight_label(elem) {
    label = elem.parentNode;

    if (elem.checked) {
		label.className = 'active';
	} else {
		label.className = 'inactive';
	}
}

function sm_switch_tab(active) {
	categories = new Array();
	categories[0] = 'status';
	categories[1] = 'email';
	categories[2] = 'sms';

	for(var i = 0; i < categories.length; i++) {
		if(categories[i] == active) {
			document.getElementById('tabs_content_' + categories[i]).style.display = 'block';
			document.getElementById('tabs_title_' + categories[i]).className = 'selected';
		} else {
			document.getElementById('tabs_content_' + categories[i]).style.display = 'none';
			document.getElementById('tabs_title_' + categories[i]).className = '';
		}
	}
}