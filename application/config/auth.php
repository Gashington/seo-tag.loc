<?php

defined('SYSPATH') or die('No direct access allowed.');

return array(
    'driver' => 'ORM',
    'hash_method' => 'sha256',
    'hash_key' => 'asjdhas6f2e12kas',
    // время жизни куков
    'lifetime' => 1209600,
    // имя переменной сессии
    'session_key' => 'auth_user',
    // Username/password combinations for the Auth File driver
    'users' => array(// 'admin' => 'b3154acf3a344170077d11bdb5fff31532f679a1919e716a02',
    ),
);

