<?php

defined('SYSPATH') or die('No direct script access.');

class Docs_Order{
    
    private $prefix = 'cont';

    public function __construct($params) {
        $arr = explode('-', $params);
        $name = $this->prefix . '_' . $arr[0];
        $type = empty($arr[1]) ? 'desc' : $arr[1];
        $this->array = array ($name, $type);        
    }
    
    public function get_order_data() {
        return $this->array;
    }
}
