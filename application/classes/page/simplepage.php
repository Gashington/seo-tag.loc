<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Статическая страница без кеширования
 */
class Page_Simplepage extends Page_Page {

    public function show($obj, $page_alias) {
        
        $page = Model::factory('pages')->get_one_page($page_alias);

        if (empty($page)) {
            $obj->action_404();           
        } else {
            $content = View::factory('index/page/view', array(
                        'page' => $page,
                            )
            );
            $obj->breadcrumbs[] = array('url' => 'page/' . $page['alias'], 'name' => $page['name']);
            $obj->template->title = $page['title'];
            $obj->template->meta_keywords = $page['meta_k'];
            $obj->template->meta_description = $page['meta_d'];
            $obj->template->content = $content;
            $obj->template->breadcrumbs = $obj->breadcrumbs;
        }
    }
}
