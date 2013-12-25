<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Страницы
 */

class Controller_Index_Map extends Controller_Index {

    public function before() {
        parent::before();
        // Вывод в шаблон
        $this->template->title = 'Управление меню';
        $this->model = Model::factory('menues');
        $this->controller = Request::current()->controller();
    }

    // Статические страницы
    public function action_index() {

        $menus_types = $this->model->get_menu_types();

        if (!$menus = $this->cache->get('cache_map')) {

            if (empty($menus_types)) {
                $menus_types = array();
                $menus = array();
            }

            foreach ($menus_types as $k => $type) {
                $menu = $this->model->get_menu(null, null, null, $type['menut_id']);
                $menus[$k]['type_name'] = $type['menut_name'];
                $menus[$k]['type_h'] = $type['menut_h'];
                $menus[$k]['type_alias'] = $type['menut_alias'];
                $menus[$k]['type_id'] = $type['menut_id'];
                $menus[$k]['type_descr'] = $type['menut_descr'];
                $menus[$k]['type_order'] = $type['menut_order'];
                $menus[$k]['menues'] = $menu;
                $menus[$k]['tree'] = $this->model->get_map($menus[$k]['menues'], 0);
            }
            $this->cache->set('cache_map', $menus);
        }

        $content = View::factory('index/' . $this->controller . '/index', array(
                    'menus' => $menus,
                    'controller' => $this->controller,
                    //'prcategories' => $categories_tree,
        ));
        $this->template->title = 'Карта сайта';
        $this->template->content = $content;

        //html::pr($menus,1);
    }

}