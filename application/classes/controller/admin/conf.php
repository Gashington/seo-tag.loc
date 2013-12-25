<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Конфиги для сайта  из базы
 */
class Controller_Admin_Conf extends Controller_Admin {

    public function before() {
        parent::before();
    }

    public function action_index() {

        $all_conf = Model::factory('conf')->get_all_conf();

        $content = View::factory('admin/conf/index', array(
                    'all_conf' => $all_conf,
        ));
        // Вывод в шаблон
        $this->template->title = 'Настройки системы';
        $this->template->content = array($content);
    }

    public function action_edit() {
        $config_key = $this->request->param('params');
        $all_conf = Model::factory('conf')->get_all_conf();
        foreach ($all_conf as $k => $v) {
            if ($v['config_key'] == $config_key) {
                $conf = $all_conf[$k];
            }
        }
        $content = View::factory('admin/conf/edit', array(
                    'conf' => $conf,
        ));
        // Вывод в шаблон
        $this->template->title = 'Настройки системы';
        $this->template->content = array($content);
    }

    public function action_add() {
        $post = Validation::factory($_POST);
        Kohana::$config->load("$post[group_name]")->set("$post[config_key]", "$post[config_value]");
        $this->request->redirect('admin/conf/index');
    }

    public function action_del() {
        $config_key = $this->request->param('params');
        Model::factory('conf')->dell_conf($config_key);
        $this->request->redirect('admin/conf');
    }

}