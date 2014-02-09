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
 * @link        http://phpservermon.neanderthal-technology.com/
 **/

namespace psm\Service;

class Template {
	protected $output;
	protected $templates = array();

	function __construct() {
		// add the main template
		$this->newTemplate('main', 'main.tpl.html');
	}

	/**
	 * Add template
	 *
	 * @param string $id template id used in the tpl file (<!--%tpl_ID-->html<!--%%tpl_ID-->)
	 * @param string $filename path to template file, or if file is located in the default template dir just the filename
	 * @return mixed false if template cannot be found, html code on success
	 */
	public function newTemplate($id, $filename) {
		if (file_exists($filename)) {
			$this->templates[$id] = $this->parseFile($filename);
		} elseif (file_exists(PSM_PATH_TPL.$filename)) {
			$this->templates[$id] = $this->parseFile(PSM_PATH_TPL.$filename);
		} else {
			// file does not exist
			trigger_error('Template not found with id: '.$id.' and filename: '.$filename);
			return false;
		}
		$use_tpl = null;

		// only get data from the file that's between the tpl id tags with this id
		// find "tpl_{$row_id}" in the current template
		//preg_match_all('{<!--%(.+?)-->(.*?)<!--%%\\1-->}is', $this->templates[$id], $matches);
		preg_match_all("{<!--%tpl_{$id}-->(.*?)<!--%%tpl_{$id}-->}is", $this->templates[$id], $matches);

		// no repeat tpl found? skip to next one
		if (empty($matches)) return false;

		// check if the row_id is in one of the matches (aka whether the supplied row id actually has a template in this file)
		if (isset($matches[1][0])) {
			$use_tpl = $matches[1][0];
		}

		// no template with the given id found..
		if ($use_tpl === null) return false;

		// remove tpl code tags from original template so it won't be in the source
		$this->templates[$id] = preg_replace("{<!--%tpl_".$id."-->(.*?)<!--%%tpl_".$id."-->}is", "", $use_tpl);

		return $this->templates[$id];
	}

	/**
	 * Add data to the template
	 *
	 * @param string $id template_id used by add_template()
	 * @param array $data
	 * @return string new template
	 */
	public function addTemplateData($id, $data) {
		// does the template exist?
		if (!isset($this->templates[$id])) {
			// file does not exist
			trigger_error('Template not found with id: '.$id);
			return false;
		}

		foreach($data as $key => $value) {
			$this->templates[$id] = str_replace('{'.$key.'}', $value, $this->templates[$id]);
		}
		return $this->templates[$id];
	}

	/**
	 * Add repeat rows to template
	 *
	 * @param string $id template id used by add_template()
	 * @param string $repeat_id ID used in template file for the repeat template: <!--%tpl_repeat_ID-->html<!--%%tpl_repeat_ID-->
	 * @param array $data
	 * @return mixed false if repeat template cannot be found, html code on success
	 */
	public function addTemplateDataRepeat($id, $repeat_id, $data) {
		// does the template exist?
		if (!isset($this->templates[$id])) {
			// file does not exist
			trigger_error('Template not found with id: '.$id);
			return false;
		}

		$use_tpl = null;

		// find "tpl_repeat_{$repeat_id}_" in the current template
		//preg_match_all('{<!--%(.+?)-->(.*?)<!--%%\\1-->}is', $this->templates[$id], $matches);
		preg_match_all("{<!--%tpl_repeat_{$repeat_id}-->(.*?)<!--%%tpl_repeat_{$repeat_id}-->}is", $this->templates[$id], $matches);

		// no repeat tpl found? skip to next one
		if (empty($matches)) return false;

		// check if the row_id is in one of the matches (aka whether the supplied row id actually has a repeat template in this file)
		if (isset($matches[1][0])) {
			$use_tpl = $matches[1][0];
		}

		// if we didn't find a repeat template for the  row_id supplied, skip the rest..
		if ($use_tpl === null) return false;

		// remove repeat tpl code from original template so it won't be in the source
		$this->templates[$id] = preg_replace("{<!--%tpl_repeat_".$repeat_id."-->(.*?)<!--%%tpl_repeat_".$repeat_id."-->}is", "", $this->templates[$id]);

		// now lets go through all the records supplied and put them in the HTML repeat code we just found
		$result = '';

		foreach($data as $record) {
			$tmp_string = $use_tpl;
			foreach($record as $k => $v) {
				$tmp_string = str_replace('{'.$k.'}', $v, $tmp_string);
			}
			$result .= $tmp_string."\n";
		}

		// add to main template..
		return $this->addTemplateData($id, array($repeat_id => $result));
	}

	public function display($id) {
		// check if there are any unused tpl_repeat templates, and if there are remove them
		$result = preg_replace('{<!--%(.+?)-->(.*?)<!--%%\\1-->}is', '', $this->templates[$id]);

		// check for tpl variables that have not been replaced. ie: {name}. ignore literal stuff, though. ie: {{name}} is {name} and should not be removed
		preg_match_all('~{?{(.+?)}}?~', $result, $matches);

		foreach($matches[0] as $match) {
			if (substr($match, 0, 2) == '{{') {
				// literal! remove only first and last bracket!
				$result = str_replace($match, substr($match, 1, -1), $result);
			} else {
				// unused variable, remove completely
				$result = str_replace($match, '', $result);
			}
		}
		return $result;
	}

	/**
	 * Get html code for a template, or if no template id given get all templates
	 *
	 * @param string $template_id
	 * @return mixed string when ID given, else array
	 */
	public function getTemplate($template_id = null) {
		if ($template_id === null) {
			return $this->templates;
		} elseif (isset($this->templates[$template_id])) {
			return $this->templates[$template_id];
		} else {
			return false;
		}
	}

	/**
	 *
	 * Get file content
	 *
	 * @param string $filename filename
	 * @return string file contents
	 */
	protected function parseFile($filename) {
		if (!file_exists($filename)) return false;

		ob_start();
		include($filename);
		$file_content = ob_get_contents();
		ob_end_clean();

		return $file_content;
	}
}

?>
