<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Главная страница
 */

class Controller_Admin_Main extends Controller_Admin {

    // имя контроллера
    protected $controller;
    protected $model;
    // информация о сайте 
    protected $site_info = NULL;
    protected $errors = array();

    public function before() {
        parent::before();
        $this->model = Model::factory('main');
        $this->controller = Request::current()->controller();
        $this->site_info = $this->model->site_info();
        $this->template->title = 'Информация о сайте';
    }

    public function action_index() {

        $content = View::factory('admin/main/index', array(
                    'site_info' => $this->site_info,
                    'controller' => $this->controller
        ));
        // Вывод в шаблон
        $this->template->title = 'Главная страница';
        $this->template->content = array($content);
    }

    public function action_editsiteinfo() {

        $site_info = $this->model->site_info();
        if (isset($_POST['submit'])) {
            $post = $this->validate_site();
            //html::pr($post,1);
            if ($post->check()) {
                $this->model->update_siteinfo($post);
                $this->request->redirect('admin/' . $this->controller);
            }
            $this->errors = $post->errors('validation');
        }

        $content = View::factory('admin/' . $this->controller . '/editsiteinfo', array(
                    'site_info' => $this->site_info,
                    'controller' => $this->controller,
                ))
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать';
    }

    /**
     * Валидация информации о сайте
     */
    protected function validate_site() {
        $post = Validation::factory($_POST);
        $post->rule('name_site', 'not_empty')
				->rule('mail_site', 'not_empty')
				->rule('mail_site', 'email')
                ->labels(array(
                    'name_site' => 'Название сайта',
					'mail_site' => 'E-mail'
        ));
        return $post;
    }

    /**
     * Загрузка изображений из CKEDITOR
     */
    public function action_ckupload() {
        parent::action_ckupload();
    }

}