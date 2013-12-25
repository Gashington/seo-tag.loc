<?php

defined('SYSPATH') OR die('No direct access allowed.');
// общие параметры
$array_db = array
    (
    'default' => array
        (
        'type' => 'mysql',
        'connection' => array(
            // постоянное соединение или каждый раз заново
            'persistent' => TRUE,
        ),
        'table_prefix' => '',
        'charset' => 'utf8',
        'caching' => FALSE,
        'profiling' => Kohana::$environment === Kohana::DEVELOPMENT,
    ),
    'alternate' => array(
        'type' => 'pdo',
        'connection' => array(
            'dsn' => 'mysql:host=localhost;dbname=kohana',
            'username' => 'root',
            'password' => 'r00tdb',
            'persistent' => FALSE,
        ),
        'table_prefix' => '',
        'charset' => 'utf8',
        'caching' => FALSE,
        'profiling' => Kohana::$environment === Kohana::DEVELOPMENT,
    ),
);
// если на локальном сервере
if (Kohana::$environment === Kohana::DEVELOPMENT) {
    $array_db = array
        (
        'default' => array
            (
            'connection' => array(
                'hostname' => '192.168.1.109',
                //'hostname' => 'localhost',
                'database' => 'seo_tag',
                'username' => 'goper',
                'password' => 'goomoonkool',
                //'username' => 'root',
                //'password' => '',
    )));
} else {
    $array_db = array
        (
        'default' => array
            (
            'connection' => array(
                'hostname' => 'localhost',
                'database' => 'seotagby_webnotes',
                'username' => 'seotagby_goper',
                'password' => 't2934851',
    )));
}
return $array_db;