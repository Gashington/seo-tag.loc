<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Conf extends Model {

    public function get_all_conf() {
        $query = DB::select()->from('config');
        return $query->execute();
    }

    public function dell_conf($config_key) {
        $query = DB::delete('config')->where('config_key', '=', $config_key)->limit(1);
        return $query->execute();
    }

}

