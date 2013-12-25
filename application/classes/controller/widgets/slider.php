<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Виджет "Слайдер работ на главной"
 */

class Controller_Widgets_Slider extends Controller_Widgets {

    // Шаблон виждета
    public $template = 'widgets/w_slider';

    // здесь мы будем обращаться к модели для получения меню
    public function action_index() {

        $dir = Kohana::$config->load('conf.dir_upload_slider');
        
        if (!$images = $this->cache->get('cache_slider')) {
            $images = Model::factory('slider')->get_slides();
            $this->cache->set('cache_slider', $images);
        }

        $this->template->images = $images;
        $this->template->dir = $dir;
    }

}