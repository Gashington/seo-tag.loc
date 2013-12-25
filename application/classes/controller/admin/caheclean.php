<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Очистка всего кеша
 */
class Controller_Admin_Caheclean extends Controller_Admin {

    public function action_index() {
        $this->cache = Cache::instance('file');
        $this->cache->delete_all();
        $this->request->redirect('admin/main');
    }

}