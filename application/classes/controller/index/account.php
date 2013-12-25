<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Личный кабинет
 */

class Controller_Index_Account extends Controller_Index {

    public function before() {
        parent::before();

        $account_menu = $this->widget_load('menuaccount');

        // Выводим в шаблон

        $this->template->account_menu = array($account_menu);
    }

    public function action_index() {

        $content = View::factory('index/account/index');

        // Выводим в шаблон
        $this->template->title = 'Личный кабинет';
        $this->template->content = $content;
    }

    public function action_orders() {

        $content = View::factory('index/account/orders');

        // Выводим в шаблон
        $this->template->title = 'Заказы';
        $this->template->content = $content;
    }

    public function action_profile() {

        $content = View::factory('index/account/profile');

        // Выводим в шаблон
        $this->template->title = 'Профиль';
        $this->template->content = $content;
    }

}