<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Контроллер статических страниц
 */
class Controller_Index_Page extends Controller_Index{
    
     public function before() {
        parent::before();
     }
     public function action_index() {    
        $page_alias = $this->request->param('page_alias');
        Factory::set('Page_Cachepage')->show($this, $page_alias);    
     }
}