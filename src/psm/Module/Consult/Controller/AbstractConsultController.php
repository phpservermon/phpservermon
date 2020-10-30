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
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v3.5.0
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Module\Consult\Controller;

use psm\Module\Server\Controller\AbstractServerController;
use psm\Service\Database;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractConsultController extends AbstractServerController
{
    /**
     * Create HTML code for the menu
     * @return string
     */
    protected function createHTMLMenu()
    {
        return '';
    }

    public function __construct(Database $db, \Twig_Environment $twig)
    {
        parent::__construct($db, $twig);

        $this->twig->addGlobal('subtitle', psm_get_lang('openscop', 'consult_title'));
        $this->twig->addGlobal('title', psm_get_lang('openscop', 'consult_title'));
    }

    protected function createHTML($html = null)
    {
        if (!$this->xhr) {
            // in XHR mode, we will not add the main template
            $tpl_data = array(
                'title' => strtoupper(psm_get_lang('openscop', 'title')),
                'label_back_to_top' => psm_get_lang('system', 'back_to_top'),
                'add_footer' => $this->add_footer,
                'version' => 'v' . PSM_VERSION,
                'messages' => $this->getMessages(),
                'html_content' => $html,
            );

            // add menu to page?
            if ($this->add_menu) {
                $tpl_data['html_menu'] = $this->createHTMLMenu();
            }
            // add header accessories to page ?
            if ($this->header_accessories) {
                $tpl_data['header_accessories'] = $this->header_accessories;
            }
            // add modal dialog to page ?
            if (sizeof($this->modal)) {
                $html_modal = '';
                foreach ($this->modal as $modal) {
                    $html_modal .= $modal->createHTML();
                }
                $tpl_data['html_modal'] = $html_modal;
            }
            // add sidebar to page?
            if ($this->sidebar !== null) {
                $tpl_data['html_sidebar'] = $this->sidebar->createHTML();
            }

            if (psm_update_available()) {
                $tpl_data['update_available'] = str_replace(
                    '{version}',
                    'v' .
                    psm_get_conf('version_update_check'),
                    psm_get_lang('system', 'update_available')
                );
            }

            if ($this->black_background) {
                $tpl_data['body_class'] = 'black_background';
            }

            $tpl_data['custom_navbar'] = true;

            // Insert logo url in navbar
            $tpl_data['logo_url'] = 'https://www.openscop.news/wp-content/uploads/sites/10/2020/04/logo_horizontal_600x150.png';
            $html = $this->twig->render('main/body.tpl.html', $tpl_data);
        }

        $response = new Response($html);

        return $response;
    }

}