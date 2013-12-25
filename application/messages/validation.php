<?php

defined('SYSPATH') or die('No direct script access.');

return array(
    'alpha' => ':field must contain only letters',
    'alpha_dash' => ':field must contain only numbers, letters and dashes',
    'alpha_numeric' => ':field must contain only letters and numbers',
    'color' => ':field must be a color',
    'credit_card' => ':field must be a credit card number',
    'date' => ':field must be a date',
    'decimal' => ':field must be a decimal with :param2 places',
    'digit' => 'Поле ":field" должно быть целым',
    'email' => 'Поле ":field" должно быть e-mail адресом',
    'email_domain' => ':field must contain a valid email domain',
    'equals' => ':field must equal :param2',
    'exact_length' => 'Поле ":field" must be exactly :param2 characters long',
    'in_array' => 'Поле ":field" must be one of the available options',
    'ip' => 'Поле ":field" должно быть ip-адерсом',
    //'matches'       => 'Поле ":field" должно быть равно ":param2"',
    'matches' => 'Пароли не совпадают',
    'min_length' => 'Поле ":field" должно быть не менее :param2 символов',
    'max_length' => 'Поле ":field" должно быть не более :param2 символов',
    'not_empty' => 'Поле ":field" не может быть пустым',
    'numeric' => ':field must be numeric',
    'phone' => ':field must be a phone number',
    'range' => ':field must be within the range of :param2 to :param3',
    'regex' => 'Введенное значение поля ":field" не подходит под заданный формат',
    'url' => 'Поле ":field" должно быть веб-адресом',
    'unique_alias' => 'Имя ":field"  уже существует',
    'unique' => 'Имя ":field"  уже существует',
    'captcha' => array(
        'Captcha::valid' => 'Символы с картинки введены неверно'
    ),
    'images' => array(
        'Upload::type' => 'Неверный формат данных',
        'Upload::size' => 'Размер загружаемого файла превышен',
        'Upload::not_empty' => 'Отсутствует загрузаемый файл'
    ),
    'backimages' => array(
        'Upload::type' => 'Неверный формат данных',
        'Upload::size' => 'Размер загружаемого файла превышен',
        'Upload::not_empty' => 'Отсутствует загрузаемый файл'
    ),
);
