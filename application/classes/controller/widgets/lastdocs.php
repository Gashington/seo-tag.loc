<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Документы из блога на главной
 */
class Controller_Widgets_Lastdocs extends Controller_Widgets {

    public $template = 'widgets/w_lastdocs';

    public function action_index() {

        $lastdocs = Model::factory('docscontents')->get_last_contents(5);

        $this->template->more_url = function($item, $alias = '') {
            foreach ($item as $v) {
                $alias .= $v['cat_alias'] . '/';
            }
            return $alias;
        };
        $this->template->docs = $lastdocs;
    }

}
