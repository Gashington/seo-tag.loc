<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Статическая страница с кешированием
 */
class Page_Cachepage extends Page_Page {

    public function show($obj, $page_alias) {
        if (!$page = $obj->cache->get('cache_'.$page_alias)) {
            $page = Model::factory('pages')->get_one_page($page_alias);
            $obj->cache->set('cache_'.$page_alias, $page);
        }
               
        if (!empty($page)) {
            $content = View::factory('index/page/view', array(
                        'page' => $page,
                            )
            );
            $obj->breadcrumbs[] = array('url' => 'page/' . $page['alias'], 'name' => $page['name']);
            // мета данные берутся из базы. Если они не заполнены, они не появятся на странице.
            $obj->template->title = $page['title'];
            $obj->template->meta_keywords = $page['meta_k'];
            $obj->template->meta_description = $page['meta_d'];
            $obj->template->content = $content;
            $obj->template->breadcrumbs = $obj->breadcrumbs;
        } else {
            $obj->action_404();
        }
    }
}
