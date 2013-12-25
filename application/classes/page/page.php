<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Page_Page{
    abstract public function show($obj, $page_alias);
}
