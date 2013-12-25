<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Главная страница
 */

class Controller_Index_Main extends Controller_Index {

    public function action_index() {
        //$token = Profiler::start('Index', 'Index');
        if (!$page = $this->cache->get('cache_main_page')) {
            $page = Model::factory('pages')->get_one_page('main');
            $this->cache->set('cache_main_page', $page);
        }
        $content = View::factory('index/main/view', array(
                    'page' => $page,
                        )
        );
        $this->template->title = $page['title'];
        $this->template->meta_keywords = $page['meta_k'];
        $this->template->meta_description = $page['meta_d'];
        $this->template->content = $content;
        //Profiler::stop($token);
    }

}