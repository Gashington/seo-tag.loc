<?php

defined('SYSPATH') or die('No direct script access.');

return array(
    // Application defaults
    'default' => array(
        // способ задачи навигации   еcли в роуте указан page, то указываем page
        //'current_page'      => array('source' => 'route', 'key' => 'page'), // source: "query_string" or "route"
        'current_page' => array('source' => 'query_string', 'key' => 'page'),
        // общее количество записей
        'total_items' => 1,
        // на страницу
        'items_per_page' => 10,
        //'view' => 'pagination/floating',
        'view' => 'pagination/basic',
        // скрывать или нет постр навигацию
        'auto_hide' => TRUE,
        // нужна ли циферка 1 если страница одна
        'first_page_in_url' => FALSE,
    ),
);
