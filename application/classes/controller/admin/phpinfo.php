<?php

defined('SYSPATH') or die('No direct script access.');

/**
*  Настройки php
*/
class Controller_Admin_Phpinfo extends Controller_Admin {
     public function before() {
        parent::before();
        echo '<a href="/admin">На главную</a>';
        phpinfo();
        die;
     }
}
