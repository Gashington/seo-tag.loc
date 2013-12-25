<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * ie
 */

class Controller_Sitemap extends Controller {

    public function before() {
        parent::before();
        $this->cache = Cache::instance('file');
    }

    public function action_index() {

        if (!$map = $this->cache->get('cache_map')) {
            $sitemap = new sitemap();
            $sitemap->set_ignore(array("javascript:", ".css", ".js", ".ico", ".jpg", ".png", ".jpeg", ".swf", ".gif", "#", "skype"));
            $sitemap->get_links(url::base());
            $map = $sitemap->generate_sitemap();
            $this->cache->set('cache_map', $map);
        }
        header("content-type: text/xml");
        echo $map;
        die;
    }

}