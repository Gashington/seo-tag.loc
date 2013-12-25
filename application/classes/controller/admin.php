<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Базовый класс главной страницы админки
 */

class Controller_Admin extends Controller_Base {

    public $template = 'admin/v_base';

    public function before() {

        parent::before();

        // если не админ, шлем на главную
        if (Auth::instance()->logged_in('admin') == false) {
            $this->request->redirect('login');
        }

        $menu_admin = $this->widget_load('menuadmin');

        $this->template->mess = '';
        //$this->template->styles[] = 'media/cssfarmework/css/bootstrap-responsive.min.css';
        $this->template->styles[] = 'media/cssfarmework/css/bootstrap.min.css';     
        $this->template->styles[] = 'media/css/core/admin.css';
        $this->template->scripts[] = 'media/js/libs/core/jquery-1.7.1.min.js';
		$this->template->scripts[] = 'media/cssfarmework/js/bootstrap.min.js';
        $this->template->scripts[] = 'media/js/libs/core/jquery.sort.js';
        $this->template->scripts[] = 'media/js/libs/core/jquery.cookie.js';
        $this->template->scripts[] = 'media/js/core/admin_plugins.js';
        $this->template->scripts[] = 'media/js/core/admin_script.js';
        $this->template->scripts[] = 'ckeditor/ckeditor.js';
        $this->template->scripts[] = 'media/js/admin_plugin.js';
        $this->template->scripts[] = 'media/js/admin_script.js';
        $this->template->menu_admin = $menu_admin;
        //$this->template->submenu = null;
    }

}