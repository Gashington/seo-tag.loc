<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Страницы
 */

class Controller_Index_Rss extends Controller_Index
{

    // имя контроллера
    protected $controller;
    // модель
    protected $model = null;

    public function before()
    {
        parent::before();
        $this->model = Model::factory('docscontents');
        $this->controller = Request::current()->controller();
    }

    public function action_index()
    {
        $blogs = $this->model->get_contents();
        $all_cats = $this->model->get_all_cats($this);
        $blogs = $this->model->get_total_contents($blogs, $all_cats);


        $info = array(
            'title' => 'Заметки WEB-разработчика',
            'language' => 'ru',
            'description' => 'Новостная лента сайта ' . url::base(),
            'link' => url::base() . 'rss',
            'pubDate' => time()
        );

        foreach ($blogs as $k => $v) {
            $items[$k]['title'] = $v['cont_name'];
            $tiser = strip_tags($v['cont_tiser']);
            $tiser = str_replace('&nbsp;', ' ', $tiser);
            $items[$k]['description'] = text::limit_words($tiser, 20);
            $items[$k]['pubDate'] = date('r', $v['cont_date']);
            $items[$k]['link'] = url::base() . $this->_get_alias($v['cats']) . $v['cont_id'];
            if ($k > 20) break;
        }

        header('Content-Type: text/xml');
        echo Feed::create($info, $items);
        die;
    }

    private function _get_alias($item, $alias = '') {
        foreach ($item as $v) {
            $alias .= $v['cat_alias'] . '/';
        }
        return $alias;
    }

}