<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Slider extends Controller_Admin {

    protected $controller;
    protected $dir;
    protected $errors = array();
    protected $mess = '';
    protected $model;
    /**
     * Максимальный размер файла
     * @var string
     */
    private $size = '5M';
    /**
     * Типы загружаемых файлов
     * @var array
     */
    private $type = array('jpg', 'png', 'gif', 'jpeg');

    public function before() {
        parent::before();
        $this->controller = Request::current()->controller();
        $this->model = Model::factory('slider');
        $this->dir = Kohana::$config->load('conf.dir_upload_slider');
    }

    public function action_index() {

        $images = $this->model->get_slides();

        $content = View::factory('admin/' . $this->controller . '/index', array(
                    'controller' => $this->controller,
                    'dir' => $this->dir,
                    'images' => $images,
        ));
        // Вывод в шаблон
        $this->template->title = 'Слайдер';
        $this->template->content = array($content);
    }

    public function action_add() {

        if (!empty($_POST['submit'])) {
            
            $post = $_POST;
            
            $img_main_validation = $this->img_main_validation();
            $img_add_validation = $this->img_add_validation();

            if ($img_main_validation->check() && $img_add_validation->check()) {
                //html::pr($_POST,1);
                $w_pr = html::filter($_POST['w_pr'], 'integer');
                $h_pr = html::filter($_POST['h_pr'], 'integer');

                $img_main = $this->upload_main_img($_FILES, $w_pr, $h_pr);
                $img_add = $this->upload_add_img($_FILES);

                $this->model->add_slide($_POST, $img_main, $img_add);
                $this->request->redirect('admin/' . $this->controller);
            }
            
            $img_main_validation_errors = $img_main_validation->errors('validation');
            $img_add_validation_errors = $img_add_validation->errors('validation');
            
            $this->errors = array_merge($img_main_validation_errors, $img_add_validation_errors);
        }

        $content = View::factory('admin/' . $this->controller . '/add', array(
                    'controller' => $this->controller,
                ))->bind('post', $post);

        $this->template->content = array($content);
        $this->template->title = 'Добавить слайд';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_edit() {

        $id = (int) $this->request->param('params');

        $images = $this->model->get_slides($id);

        $params = json_decode($images[0]['params'], true);

        if (!empty($_POST['submit'])) {

            $img_main_validation = $this->img_main_validation();
            $img_add_validation = $this->img_add_validation();

            $post = $_POST;

            if ($img_main_validation->check() && $img_add_validation->check()) {
                $w_pr = html::filter($_POST['w_pr'], 'integer');
                $h_pr = html::filter($_POST['h_pr'], 'integer');

                $img_main = $this->upload_main_img($_FILES, $w_pr, $h_pr);
                $img_add = $this->upload_add_img($_FILES);

                if (empty($img_main)) {
                    $img_main = $images[0]['img_main'];
                } else {
                    if (is_file($this->dir . '/' . $images[0]['img_main'])) {
                        unlink($this->dir . '/' . $images[0]['img_main']);
                        unlink($this->dir . '/small_' . $images[0]['img_main']);
                    }
                }

                if (empty($img_add)) {
                    $img_add = $images[0]['img_add'];
                } else {
                    if (is_file($this->dir . '/back/' . $images[0]['img_add'])) {
                        unlink($this->dir . '/back/' . $images[0]['img_add']);
                        unlink($this->dir . '/back/small_' . $images[0]['img_add']);
                    }
                }
                $this->model->edit_slide($id, $_POST, $img_main, $img_add);
                $this->request->redirect('admin/' . $this->controller);
            }
            
            $img_main_validation_errors = $img_main_validation->errors('validation');
            $img_add_validation_errors = $img_add_validation->errors('validation');
            
            $this->errors = array_merge($img_main_validation_errors, $img_add_validation_errors);
        }

        $content = View::factory('admin/' . $this->controller . '/edit', array(
                    'controller' => $this->controller,
                    'path' => $this->dir,
                    'params' => $params,
                    'image' => $images[0],
                ))->bind('post', $post);
        // Вывод в шаблон
        $this->template->content = array($content);
        $this->template->title = 'Редактировать слайд';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_delete() {
        $id = (int) $this->request->param('params');
        $this->model->delete_slide($id);
        $this->request->redirect('admin/' . $this->controller);
    }

    public function action_removechecked() {
        //html::pr($_POST,1);
        $check_slides = empty($_POST['check_slides']) ? array() : $_POST['check_slides'];
        //html::pr($check_docs,1);
        foreach ($check_slides as $k => $v) {
            $k = (int) $k;
            $this->model->delete_slide($k);
        }
        $this->request->redirect('admin/' . $this->controller);
    }

    /**
     * AJAX сортировка материалов
     */
    public function action_editorder() {

        $slider_id = $_POST['slider_id'];
        $slider_ids = explode(',', $slider_id);

        $slider_order = $_POST['slider_order'];
        $slider_orders = explode(',', $slider_order);


        if ($this->model->edit_slider_order($slider_ids, $slider_orders))
            echo ('Порядок изменен');
        die;
    }

    /**
     * Валидация изображений слайдера
     * @return object
     */
    protected function img_main_validation() {
        $validation = Validation::factory($_FILES)
                ->rule('images', 'Upload::type', array(':value', $this->type))
                ->rule('images', 'Upload::size', array(':value', $this->size))
                ->labels(array(
            'images' => 'Файл'
        ));
        return $validation;
    }
    
    /**
     * Валидация дополнительных изображений слайдера
     * @return object
     */
    protected function img_add_validation() {
        $validation = Validation::factory($_FILES)
                ->rule('backimages', 'Upload::type', array(':value', $this->type))
                ->rule('backimages', 'Upload::size', array(':value', $this->size))
                ->labels(array(
            'images' => 'Файл'
        ));
        return $validation;
    }

    /**
     * Загрузка слайда
     * @param array $FILES
     * @param int $w_pr Ширина превью
     * @param int $h_pr Высота превью
     * @return string $img Имя сформированного изображения
     */
    protected function upload_main_img($FILES, $w_pr, $h_pr) {
        if (!empty($FILES['images']['name'])) {
            $ext = pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);
            $img = $this->_upload_img($_FILES['images']['tmp_name'], $ext, $this->dir, true, $w_pr, $h_pr);
            return empty($img) ? '' : $img;
        }
        return '';
    }

    /**
     * Загрузка доп. изображения
     * @param array $FILES 
     * @return string $img Имя сформированного изображения 
     */
    protected function upload_add_img($FILES) {
        $dir_upload = $this->dir . '/back';
        $w = Kohana::$config->load('conf.img_add_preview_slider_w');
        $h = Kohana::$config->load('conf.img_add_preview_slider_h');
        if (!empty($FILES['backimages']['name'])) {
            $ext = pathinfo($FILES['backimages']['name'], PATHINFO_EXTENSION);
            $img = $this->_upload_img($FILES['backimages']['tmp_name'], $ext, $dir_upload, TRUE, $w, $h);
            return empty($img) ? '' : $img;
        }
        return '';
    }

}

