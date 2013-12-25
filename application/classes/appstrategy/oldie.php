<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Что делать если старый ie
 */
class Appstrategy_Oldie extends Appstrategy_Appnamingstrategy {

    public function make() {
        if (Kohana::$config->load('conf.old_br_redirect') == true) {        
            Request::initial()->redirect('ie');
        }
    }

}
