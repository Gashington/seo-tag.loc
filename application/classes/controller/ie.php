<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * ie
 */

class Controller_Ie extends Controller_Index {

    public $template = 'index/ie';

    public function before() {
        parent::before();
    }

    public function action_index() {
        $this->template->title = 'Устаревшая версия браузера';
        $this->template->version = (int) $this->browser['version'];
        $this->template->brows = $this->browser['brows'];
    }

}