<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Widgets_Categories extends Controller_Widgets {

    public $template = 'widgets/w_categories';

    public function action_index() {
        
        $this->template->categories = empty($categories) ? array() : $categories;
    }

}
