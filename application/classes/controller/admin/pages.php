<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller_Admin {

    protected $errors = array();
    protected $mess = '';
    protected $model = NULL;
    protected $params = NULL;

    /**
     * Путь до папки с изображениями
     * @var string
     */
    protected $dir_upload_preview = NULL;

    /**
     * Ширина превью
     * @var string
     */
    protected $w = NULL;

    /**
     * Высота превью
     * @var string
     */
    protected $h = NULL;

    public function before() {
        parent::before();

        // Вывод в шаблон
        $this->template->title = 'Страницы';
        $this->template->errors = $this->errors;
        $this->template->mess = $this->mess;
        // для валидации на уникальность alias
        $this->model = Model::factory('pages');
        $this->dir_upload_preview = Kohana::$config->load('conf.dir_upload_preview');
        $this->w = Kohana::$config->load("conf.img_preview_page_w");
        $this->h = Kohana::$config->load("conf.img_preview_page_h");
        $this->params = $this->request->param('params');
    }

    public function action_index() {

        $pages = $this->model->get_pages();
        $content = View::factory('admin/pages/index', array(
                    'pages' => $pages,
        ));
        $this->template->content = array($content);
    }

    public function action_edit() {
        
        $pages = $this->model->get_one_page(NULL, $this->params);
        
        if (isset($_POST['submit'])) {
            $post = $this->validate();
            $upload = $this->img_validation($_FILES);

            if ($post->check() && $upload->check()) {

                $img_uload = $this->_upload_preview_img($_FILES, $this->dir_upload_preview, $this->w, $this->h);

                if (empty($img_uload)) {
                    $img_uload = $pages['img'];
                } else {
                    $this->model->unlink_preview($this->dir_upload_preview, $pages['img']);
                }

                $this->model->edit_page($post, $this->params, $img_uload);
                
                $this->request->redirect('admin/pages/');
            }
            $upload_err = $upload->errors('validation');
            $post_err = $post->errors('validation');
            $this->errors = array_merge($upload_err, $post_err);
        }

        $content = View::factory('admin/pages/edit', array(
                    'pages' => $pages,
                ))
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать';
    }

    public function action_add() {

        if (!empty($_POST['submit'])) {

            $upload = $this->img_validation();
            $post = $this->validate();

            if ($post->check() && $upload->check()) {

                // загрузка изображения
                $img = $this->_upload_preview_img($_FILES, $this->dir_upload_preview, $this->w, $this->h);
                $img = !empty($img) ? $img : '';

                $this->model->add_page($post, $img);
                $this->request->redirect('admin/pages/');
            }
            // собираем ошибки
            $upload_err = $upload->errors('validation');
            $post_err = $post->errors('validation');
            $this->errors = array_merge($upload_err, $post_err);
        }

        $content = View::factory('admin/pages/add')
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->content = array($content);
        $this->template->title .= ' :: Добавить';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_delete() {       
        $result = $this->model->get_one_page(NULL, $this->params);
        html::del_imgs_from_content($result['content']);       
        $this->model->unlink_preview($this->dir_upload_preview, $result['img']);
        $this->model->delete_page($this->params);
        $this->request->redirect('admin/pages');
    }
    
    /**
     * Удалить превью
     */
    public function action_delpreview() {
        $dir_upload = Kohana::$config->load('conf.dir_upload_preview');
        $result = $this->model->get_one_page(NULL, $this->params);
        $this->model->unlink_preview($this->dir_upload_preview, $result['img']);
        $this->model->delpreview_page($this->params);
        $this->request->redirect('admin/pages/edit/'.$this->params);
    }
    /**
     * Удалить выбранные
     */
    public function action_removechecked() {
        $check_pages = empty($_POST['check_page']) ? array() : $_POST['check_page'];
        //html::pr($check_pages,1);
        foreach ($check_pages as $k => $v) {
            $k = (int) $k;
            $result = $this->model->get_one_page(NULL, $k);
            html::del_imgs_from_content($result['content']);       
            $this->model->unlink_preview($this->dir_upload_preview, $result['img']);          
            $this->model->delete_page($k);
        }
        $this->request->redirect('admin/pages');
    }

    /**
     * Валидация входных данных
     * @return object 
     */
    private function validate() {
        $post = Validation::factory($_POST);
        $post->rule('name', 'not_empty')
                ->rule('alias', 'not_empty')
                ->rule('alias', 'regex', array(':value', '/^[a-z0-9\-]++$/iD'))
                //->rule('content', 'min_length', array(':value', '10'))
                ->rule('alias', array($this->model, 'unique_alias'), array($post['alias'], $this->params))
                ->labels(array(
                    'name' => 'Название',
                    'alias' => 'Алиас',
                    //'content' => 'Контент',
        ));
        return $post;
    }

    /**
     * Валидация изображений
     * @return object
     */
    private function img_validation() {
        $valid_types = array('jpg', 'png', 'gif', 'jpeg');
        $validation = Validation::factory($_FILES)
                //->rule('images', 'Upload::not_empty')
                ->rule('images', 'Upload::type', array(':value', $valid_types))
                ->rule('images', 'Upload::size', array(':value', '5M'))
                ->labels(array(
            'images' => 'Файл'
        ));
        return $validation;
    }
    
    

}