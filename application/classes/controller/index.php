<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Базовый класс главной страницы
 */

class Controller_Index extends Controller_Base {

    // назначаем гланвый шаблон
    public $template = 'index/carcass';
    protected $browser;

    public function before() {

        parent::before();

        // загрузка виджетов
        $widgets = Model::factory('widgets')->get_widgets();

        foreach ($widgets as $k => $item) {
            $widget = 'w_' . $item['alias'];
            if ($item['show'] > 0 || Auth::instance()->logged_in('admin')) {
                $this->template->$widget = $this->widget_load($item['alias']);
            } else {
                $this->template->$widget = '';
            }
        }
    }

    public function action_404() {
        $this->response->status(404);
        $this->template->title = 'Страница не найдена';
        $content = View::factory('errors/404', array(
                    'page' => '$page',
                        )
        );
        $this->template->content = $content;
    }

}