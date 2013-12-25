<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Виджет "Меню админа"
 */

class Controller_Widgets_Menuadmin extends Controller_Widgets {

    public $template = 'widgets/w_menuadmin'; // Шаблон виждета

    public function action_index() {
        $select = Request::initial()->controller();
        $menu = array(
            array('link' => 'docs/index/all', 'name' => 'Блоги', 'match' => 'docs'),
            array('link' => 'categories', 'name' => 'Категории блогов', 'match' => 'categories'),
            array('link' => 'comments', 'name' => 'Комментарии', 'match' => 'comments'),
            array('link' => 'widgets', 'name' => 'Виджеты', 'match' => 'widgets'),
            array('link' => 'pages', 'name' => 'Страницы', 'match' => 'pages'),
            array('link' => 'menues', 'name' => 'Меню', 'match' => 'menues'),           
            array('link' => 'media', 'name' => 'Медиа', 'match' => 'media'),
             //array('link' => 'projects', 'name' => 'Проекты', 'match' => 'projects'),
             //array('link' => 'services', 'name' => 'Услуги', 'match' => 'services'),
            //array('link' => 'reviews', 'name' => 'Озывы', 'match' => 'reviews'),
            //array('link' => 'answers', 'name' => 'Вопрос-ответ', 'match' => 'answers'),
            //array('link' => 'comments', 'name' => 'Комментарии', 'match' => 'comments'),
            //array('link' => 'gallery', 'name' => 'Фотогалерея', 'match' => 'gallery'),
            array('link' => 'slider', 'name' => 'Слайдер', 'match' => 'slider'),
        );

        // Вывод в шаблон
        $this->template->menu = $menu;
        $this->template->select = $select;
    }

}