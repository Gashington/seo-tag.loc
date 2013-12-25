<?php

defined('SYSPATH') or die('No direct script access.');

class Model_User extends Model_Auth_User {

    public function labels() {
        return array(
            'username' => 'Логин',
            'email' => 'E-mail',
            'first_name' => 'ФИО',
        );
    }

    public static function get_password_validation($values) {
        return Validation::factory($values)
                        ->rule('password', 'min_length', array(':value', 5))
                        ->rule('password_confirm', 'matches', array(':validation', ':field', 'password'))
                        ->labels(array(
                            'password' => 'Пароль',
                            'password_confirm' => 'Повторить пароль',
        ));
    }

    public function rules() {
        return array(
            'username' => array(
                array('not_empty'),
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 32)),
                array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
                array(array($this, 'unique'), array('username', ':value')),
            ),
            'first_name' => array(
                array('not_empty'),
                array('min_length', array(':value', 2)),
                array('max_length', array(':value', 32)),
            ),
            'password' => array(
                array('not_empty'),
            ),
            'email' => array(
                array('not_empty'),
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 127)),
                array('email'),
                array(array($this, 'unique'), array('email', ':value')),
            ),
            'password_confirm' => array()
        );
    }

    public function saveNewPass($password, $auth) {

        $hash_password = $auth->hash_password($password);

        $userId = $auth->get_user()->id;

        $query = DB::update('users')->set(
                        array(
                            'password' => $hash_password,
                        )
                )->where('id', '=', $userId);

        $query->execute();

        return TRUE;
    }

}

