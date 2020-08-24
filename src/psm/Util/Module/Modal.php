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
 * @author      Pepijn Over <pep@mailbox.org>
 * @author      Jérôme Cabanis <jerome@lauraly.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Util\Module;

class Modal implements ModalInterface
{

    const MODAL_TYPE_OK = 0;
    const MODAL_TYPE_OKCANCEL = 1;
    const MODAL_TYPE_DANGER = 2;

    /**
     * prefix used for modal dialog box elements
     * @var string $modal_id
     */
    protected $modal_id;

    /**
     * @var int $type Type of modal dialog
     */
    protected $type;

    /**
     * Modal dialog title
     * @var string $title
     */
    protected $title;

    /**
     * Modal dialog message
     * @var string $body
     */
    protected $message;

    /**
     * label of the OK button
     * @var string $ok_label
     */
    protected $ok_label;

    /**
     * Twig environment
     * @var \Twig_Environment $twig
     */
    protected $twig;

    public function __construct(\Twig_Environment $twig, $modal_id = 'main', $type = self::MODAL_TYPE_OK)
    {
        $this->modal_id = $modal_id;
        $this->twig = $twig;
        $this->type = $type;
    }

    /**
     * get the modal dialog box element prefix
     * @return string
     */
    public function getModalID()
    {
        return $this->modal_id;
    }

    /**
     * Set the modal dialog type
     * @param int $type
     * @return \psm\Util\Module\Modal
     */
    public function setType($type)
    {
        if (in_array($type, array(self::MODAL_TYPE_OK, self::MODAL_TYPE_OKCANCEL, self::MODAL_TYPE_DANGER))) {
            $this->type = $type;
        }
        return $this;
    }

    /**
     * Set the modal dialog title
     * @param string $title
     * @return \psm\Util\Module\Modal
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set the modal dialog message
     * @param string $message
     * @return \psm\Util\Module\Modal
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setOKButtonLabel($label)
    {
        $this->ok_label = $label;
        return $this;
    }

    public function createHTML()
    {
        $has_cancel = ($this->type == self::MODAL_TYPE_OK) ? false : true;
        $button_type = ($this->type == self::MODAL_TYPE_DANGER) ? 'danger' : 'primary';
        $button_label = empty($this->ok_label) ? psm_get_lang('system', 'ok') : $this->ok_label;
        $message = !empty($this->message) ? $this->message : '';

        $matches = array();
        if (preg_match_all('/%(\d)/', $message, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $message = str_replace($match[0], '<span class="modalP' . $match[1] . '"></span>', $message);
            }
        }

        $tpl = $this->twig->loadTemplate('util/module/modal.tpl.html');
        $html = $tpl->render(array(
            'modal_id' => $this->modal_id,
            'modal_title' => !empty($this->title) ? $this->title : psm_get_conf('site_title', psm_get_lang('system', 'title')),
            'modal_body' => $message,
            'has_cancel' => $has_cancel,
            'label_cancel' => psm_get_lang('system', 'cancel'),
            'modal_button_type' => $button_type,
            'modal_button_label' => $button_label,
        ));

        return $html;
    }
}
