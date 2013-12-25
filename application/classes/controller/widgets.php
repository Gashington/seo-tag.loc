<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Базовый класс виджетов
 */
class Controller_Widgets extends Controller_Base {

    public function before() {
        parent::before();
        // инициализируем кеширование в виджетах
        $this->cache = Cache::instance('file');
        // по умолчанию запрещаем вывод
        $this->auto_render = FALSE;
        // название виджета
        $widget_name = Request::current()->controller();
        
        $widget = Model::factory('widgets')->get_one_widget(null, $widget_name);

        $widget_conf = $widget['config'];

        if (!empty($widget_conf)) {
            if ($widget_conf == 'all') {
                $this->auto_render = TRUE;
                return TRUE;
            } else {
                $widget_conf = explode(',', $widget_conf);
                foreach ($widget_conf as $v) {   
                    if (preg_match($v, url::curr('short', NULL, TRUE))) {
                        $this->auto_render = TRUE;
                        return TRUE;
                    }
                }
                return FALSE;
            }
        }
    }

}
