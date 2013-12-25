<?php

defined('SYSPATH') or die('No direct script access.');

return array
    (
    'file' => array(
        'driver' => 'file',
        'cache_dir' => APPPATH . 'cache',
        // месяц
        'default_expire' => 3600 * 60 * 24 * 30,
        'ignore_on_delete' => array(
            '.gitignore',
            '.git',
            '.svn'
        )
    )
);

