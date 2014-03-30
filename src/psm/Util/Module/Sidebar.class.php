<?php
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
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Util\Module;
use psm\Service\Template;

class Sidebar implements SidebarInterface {

	/**
	 * ID of active item
	 * @var string $active_id
	 * @see setActiveItem()
	 */
	protected $active_id;

	/**
	 * List of all sidebar items
	 * @var array $items
	 */
	protected $items = array();

	/**
	 * Custom subtitle
	 * @var string $subtitle
	 * @see setSubtitle()
	 */
	protected $subtitle;

	/**
	 * Template service
	 * @var \psm\Service\Template $tpl
	 */
	protected $tpl;

	public function __construct(Template $tpl) {
		$this->tpl = $tpl;
	}

	/**
	 * Set active item
	 * @param string $id
	 * @return \psm\Util\Module\Sidebar
	 */
	public function setActiveItem($id) {
		$this->active_id = $id;
		return $this;
	}

	/**
	 * Set a custom subtitle (default is module subitle)
	 * @param string $title
	 * @return \psm\Util\Moduke\Sidebar
	 */
	public function setSubtitle($title) {
		$this->subtitle = $title;
		return $this;
	}

	/**
	 * Add new link to sidebar
	 * @param string $id
	 * @param string $label
	 * @param string $url
	 * @param string $icon
	 * @return \psm\Util\Module\Sidebar
	 */
	public function addLink($id, $label, $url, $icon = null) {
		if(!isset($this->items['link'])) {
			$this->items['link'] = array();
		}

		$this->items['link'][$id] = array(
			'type' => 'link',
			'label' => $label,
			'url' => str_replace('"', '\"', $url),
			'icon' => $icon,
		);
		return $this;
	}

	public function createHTML() {
		$tpl_id = 'main_sidebar_container';
		$this->tpl->newTemplate($tpl_id, 'main_sidebar.tpl.html');

		$types = array('link');
		$items = array();

		// loop through all types and build their html
		foreach($types as $type) {
			if(empty($this->items[$type])) {
				// no items for this type
				continue;
			}
			// retrieve template for this type once so we can use it in the loop
			$tpl_id_type = 'main_sidebar_types_' . $type;
			$this->tpl->newTemplate($tpl_id_type, 'main_sidebar.tpl.html');
			$html_type = $this->tpl->getTemplate($tpl_id_type);

			// build html for each individual item
			foreach($this->items[$type] as $id => $item) {
				$items[] = array(
					'html_item' => $this->tpl->addTemplateData($html_type, $item, true),
					'class_active' => ($id === $this->active_id) ? 'active' : '',
				);
			}
		}
		if(!empty($items)) {
			$this->tpl->addTemplateDataRepeat($tpl_id, 'items', $items);
		}
		if($this->subtitle !== null) {
			$this->tpl->addTemplateData($tpl_id, array(
				'subtitle' => $this->subtitle,
			));
		}

		$html = $this->tpl->getTemplate($tpl_id);

		return $html;
	}
}