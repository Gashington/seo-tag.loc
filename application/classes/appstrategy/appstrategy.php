<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Непосредственно сама стратегия, распределение действий
 */
class Appstrategy_Appstrategy {

    public function __construct(Browser $app) {
        
        $brows = $app->getBrowser();
        $version = $app->getVersion();
        
        if ($brows == Browser::BROWSER_IE && Request::initial()->controller() != 'ie' && (int) $version <= 7) {
                $obj = new Appstrategy_Oldie();
                $obj->make();
        }
    }
}
