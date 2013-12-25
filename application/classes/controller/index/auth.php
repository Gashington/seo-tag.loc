<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Авторизация
 */

class Controller_Index_Auth extends Controller_Index {

    public function before() {
        parent::before();
    }

    public function action_index() {
        $this->action_login();
    }

    public function action_login() {

        if (Auth::instance()->logged_in('admin')) {
            $this->request->redirect('admin');
        }

        if (isset($_POST['submit'])) {

            $data = Arr::extract($_POST, array('username', 'password', 'remember'));
            $status = Auth::instance()->login($data['username'], $data['password'], (bool) $data['remember']);

            if ($status) {
                if (Auth::instance()->logged_in('admin')) {
                    $this->request->redirect('admin');
                }

                $this->request->redirect('account');
            } else {
                $errors = array(Kohana::message('auth/user', 'no_user'));
            }
        }

        $content = View::factory('index/auth/login')
                ->bind('errors', $errors)
                ->bind('data', $data);

        // Выводим в шаблон
        $this->template->title = 'Вход';
        $this->template->content = $content;
    }

    public function action_register() {
        if (Auth::instance()->logged_in('admin')) {
            $this->request->redirect('account');
        }

        $errors = '';
        if (isset($_POST['submit'])) {
            $data = Arr::extract($_POST, array('username', 'password', 'first_name', 'password_confirm', 'email'));
            $users = ORM::factory('user');

            try {
                $users->create_user($_POST, array(
                    'username',
                    'first_name',
                    'password',
                    'email',
                ));

                $role = ORM::factory('role')->where('name', '=', 'login')->find();
                $users->add('roles', $role);
                $this->action_login();
                $this->request->redirect('account');
            } catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('auth');
            }
        }

        $content = View::factory('index/auth/register')
                //->bind('errors', $errors)
                ->bind('data', $data);

        // Выводим в шаблон
        $this->template->title = 'Регистрация';
        $this->template->content = $content;
        $this->template->errors = $errors;
    }

    public function action_logout() {
        if (Auth::instance()->logout()) {
            $this->request->redirect('login');
        }
    }

    public function action_change() {
        if (Auth::instance()->logged_in('admin')) {

            $users = Model::factory('user');
            $errors = '';
            $auth = Auth::instance();
            $userId = $auth->get_user()->id;


            if (isset($_POST['submit'])) {

                $post = $this->pass_validate($_POST);

                $password = $post['password'];


                if ($post->check()) {
                    $users->saveNewPass($password, $auth);
                    Auth::instance()->logout();
                    $this->request->redirect('login');
                }
                $errors = $post->errors('validation');
            }

            $content = View::factory('index/auth/change')
                    ->bind('data', $data);

            // Выводим в шаблон
            $this->template->title = 'Регистрация';
            $this->template->content = $content;
            $this->template->errors = $errors;
        } else {
            $this->request->redirect('login');
        }
    }

    protected function pass_validate($post) {
        $post = Validation::factory($_POST);
        $post->rule('password', 'min_length', array(':value', 5))
                ->rule('password', 'not_empty')
                ->rule('password_confirm', 'matches', array(':validation', ':field', 'password'))
                ->labels(array(
                    'password' => 'Пароль',
                    'password_confirm' => 'Повторный пароль'
        ));
        return $post;
    }

}