<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Контроллер Галереи
 * Имя view и model должны совпадать с именем контроллера
 */

class Controller_Admin_Gallery extends Controller_Admin {

    // ошибки и сообщения
    protected $errors = array();
    protected $mess = '';
    protected $params = null;
    protected $alias = null;
    // модель
    protected $model = null;
    // разделитель
    protected $s = '/';
    // имя контроллера
    protected $controller;
    protected $id = null;

    public function before() {
        parent::before();
        $this->template->title = 'Галерея';
        $this->template->errors = $this->errors;
        $this->template->mess = $this->mess;
        $this->model = Model::factory('gallery');
        $this->controller = Request::current()->controller();
        $this->params = trim($this->request->param('params'));
        $this->dir_upload_gallery = Kohana::$config->load('conf.dir_upload_gallery');
        $this->id = empty($this->params) ? null : (int) $this->params;
    }

    public function action_index() {

        if ($this->params == 'sortcat') {
            $this->sortcat();
        }
        
        $galleries = $this->model->get_gallery();
        $gcategories = $this->model->get_gcategories();

        $content = View::factory('admin/' . $this->controller . '/index', array(
                    'gcategories' => $gcategories,
                    'galleries' => $galleries,
                    'controller' => $this->controller,
                    'path' => $this->dir_upload_gallery . '/categories'
        ));
        
        if (!empty($_GET['err']))
            $this->template->errors = array($_GET['err']);
        
        $this->template->content = array($content);
    }

    public function action_add() {

        $gcategories = $this->model->get_gcategories();

        if (!empty($_POST['submit'])) {

            $post = $this->validate_gallery();

            if ($post->check()) {
                $w = Kohana::$config->load("conf.img_preview_gal_w");
                $h = Kohana::$config->load("conf.img_preview_gal_h");
                $img = implode('|', $this->upload_gallery_img($_FILES, $this->dir_upload_gallery, $w, $h));
                $this->model->add_gallery($post, $img);
                $this->request->redirect('admin/' . $this->controller . '/index/');
            }

            $this->errors = $post->errors('validation');
        }

        $content = View::factory('admin/' . $this->controller . '/add', array(
                    'gcategories' => $gcategories,
                    'controller' => $this->controller,
                    'path' => $this->dir_upload_gallery
                ))
                //->bind('errors', $errors)
                ->bind('post', $post);
        $this->template->content = array($content);
        $this->template->title .= ' :: Добавить';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }
    public function action_del() {
        $this->model->delete_gallery($this->id);
        $this->request->redirect('admin/' . $this->controller);
    }
    public function action_edit() {
        
        $galleries = $this->model->get_gallery($this->id);
        
        $id_category = $galleries[0]['g_cat_id'];
        
        $gcategories = $this->model->get_gcategories($id_category);

 
        if (!empty($_POST['submit'])) {

            $post = $this->validate_gallery();

            if ($post->check()) {
                $w = Kohana::$config->load("conf.img_preview_gal_w");
                $h = Kohana::$config->load("conf.img_preview_gal_h");
                $post_imgs = $this->upload_gallery_img($_FILES, $this->dir_upload_gallery, $w, $h);
                $g_imgs = empty($galleries[0]['g_img']) ? array() : explode('|', $galleries[0]['g_img']);
                $imgs = array_merge($g_imgs, $post_imgs);
                $img = implode('|', $imgs);
                
                $this->model->update_gallery($post, $img, $this->id);
                $this->request->redirect('admin/' . $this->controller . '/index/');
            }

            $this->errors = $post->errors('validation');
        }

        $content = View::factory('admin/' . $this->controller . '/edit', array(
                    'gcategories' => $gcategories,
                    'gallery' => $galleries[0],
                    'controller' => $this->controller,
                    'path' => $this->dir_upload_gallery,
                    'cat_id' => $id_category
                ))
                //->bind('errors', $errors)
                ->bind('post', $post);
        $this->template->content = array($content);
        $this->template->title .= ' :: Добавить';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_addcat() {

        if (!empty($_POST['submit'])) {

            $post = $this->validate_gcategory();

            if ($post->check()) {
                $w = Kohana::$config->load("conf.img_preview_galcat_w");
                $h = Kohana::$config->load("conf.img_preview_galcat_h");
                $dir_upload = $this->dir_upload_gallery . '/categories';
                $img = $this->upload_gallery_img($_FILES, $dir_upload, $w, $h);
                $img = isset($img[0]) ? $img[0] : '';

                $this->model->add_gcategory(
                        $post, $img
                );
                $this->request->redirect('admin/' . $this->controller);
            }

            $this->errors = $post->errors('validation');
        }

        $content = View::factory('admin/' . $this->controller . '/addcat', array(
                    'controller' => $this->controller,
                ))
                //->bind('errors', $errors)
                ->bind('post', $post);
        $this->template->content = array($content);
        $this->template->title = 'Добавить категорию';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_editcat() {

        $gcategories = $this->model->get_gcategories($this->id);
        $gcategory = $gcategories[0];
        $dir_upload = $this->dir_upload_gallery . '/categories';
        $img = !empty($gcategory['gcat_img']) ? $gcategory['gcat_img'] : null;

        if (isset($_POST['submit'])) {

            $post = $this->validate_gcategory();

            if ($post->check()) {
                
                $w = Kohana::$config->load("conf.img_preview_galcat_w");
                $h = Kohana::$config->load("conf.img_preview_galcat_h");

                $img_uploads = $this->upload_gallery_img($_FILES, $dir_upload, $w, $h);

                if (!empty($img_uploads[0])) {
                    $img_upload = $img_uploads[0];
                    if($img){
                        unlink($dir_upload . '/' . $img);
                        unlink($dir_upload . '/small_' . $img);
                    }
                } else {
                    $img_upload = null;
                }

                $this->model->update_gcategory(
                        $post, $img_upload, $this->id
                );
                $this->request->redirect('admin/' . $this->controller);
            }
            $this->errors = $post->errors('validation');
        }
        $content = View::factory('admin/' . $this->controller . '/editcat', array(
                    'gcategory' => $gcategory,
                    'img' => $img,
                    'controller' => $this->controller,
                    'patch' => $dir_upload,
                ))->bind('post', $post);

        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать категорию';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_delcat() {

        $res = $this->model->delete_cat($this->id);
        $err1 = 'Нельзя удалить категорию, если к ней привязаны материалы!';
        switch ($res) {
            case 2 : $this->request->redirect('admin/' . $this->controller . '/?err=' . $err1);
                break;
            default : $this->request->redirect('admin/' . $this->controller);
        }
    }

    /**
     * Загрузка изображения галереи
     */

    protected function upload_gallery_img($FILES, $dir_upload, $w = FALSE, $h = FALSE) {

        if (!empty($FILES['images']['name'][0])) {
            foreach ($FILES['images']['name'] as $item => $image) {
                $ext = pathinfo($image, PATHINFO_EXTENSION);
                if ($ext == 'jpg' || $ext == 'gif' || $ext == 'png' || $ext == 'jpeg') {
                    $imgs[] = $this->_upload_img($FILES['images']['tmp_name'][$item], $ext, $dir_upload, TRUE, $w, $h);
                }
            }
            return $imgs;
        }
        return array();
    }

    /**
     * Валидация категорий
     */

    protected function validate_gcategory() {
        $post = Validation::factory($_POST);
        $post->rule('name', 'not_empty')
                ->rule('alias', 'not_empty')
                ->rule('alias', 'regex', array(':value', '/^[A-zА-я0-9\-]++$/iD'))
                ->rule('alias', array($this->model, 'unique_alias'), array($post['alias'], $this->id))
                ->labels(array(
                    'name' => 'Название',
                    'alias' => 'Алиас',
        ));
        return $post;
    }

    /**
     * Валидация галареи
     */

    protected function validate_gallery() {
        $post = Validation::factory($_POST);
        $post->rule('cat_id', 'digit')
                ->labels(array(
                    'cat_id' => 'Категории',
        ));
        return $post;
    }

    /**
     * Сортировка категорий AJAX
     */
    protected function sortcat() {

        $sortcats = $_POST['sortcat'];
        html::pr($sortcats);
        foreach ($sortcats as $order => $id) {
            //echo 'ордер '.$order.' id '.$id;
            $this->model->sortcats($id, $order);
        }
        echo 'готово!';
        //$this->model->edit_products_imgs($imgs, $pr_id);
        die;
    }

    /*
     * AJAX- метод изменение количества изображений в базе и папке
     * 
     */

    public function action_editimg() {

        $imgstr = html::filter($_POST['imgs']);       
        $imgs = explode(',', $imgstr);
        $g_id = html::filter($_POST['g_id'], 'integer');
        $this->model->edit_gallery_imgs($imgs, $g_id);
        die;
    }
    
    /*
     * AJAX- метод изменение количества изображений в базе и папке
     * 
     */

    public function action_sortimg() {
        $sortimg = $_POST['sortimg'];
        $id = html::filter($_POST['g_id'], 'integer');       
        $this->model->sortimg($id, $sortimg);
        echo 'готово!';
        //$this->model->edit_products_imgs($imgs, $pr_id);
        die;
    }

}