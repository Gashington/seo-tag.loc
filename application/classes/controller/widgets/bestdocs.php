<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Документы из блога на главной
 */
class Controller_Widgets_Bestdocs extends Controller_Widgets {

    public $template = 'widgets/w_bestdocs';

    public function action_index() {

        if (!$bestdocs = $this->cache->get('cache_bestdocs')) {
            $bestdocs = Model::factory('docscontents')->get_main_contents();
            $this->cache->set('cache_bestdocs', $bestdocs);
        }

        $this->template->more_url = function($item, $alias = '') {
            foreach ($item as $v) {
                $alias .= $v['cat_alias'] . '/';
            }
            return $alias;
        };
        $this->template->docs = $bestdocs;
    }

}
