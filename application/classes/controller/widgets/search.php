<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Виджет "Форма поиска"
 */

class Controller_Widgets_Search extends Controller_Widgets {

    public $template = 'widgets/w_search';

    public function action_index() {
       $this->template->min_word = Model::factory('search')->get_min_word();
    }

}