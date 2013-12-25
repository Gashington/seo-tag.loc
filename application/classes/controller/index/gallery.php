<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Фото галерея
 */

class Controller_Index_Gallery extends Controller_Index {

    // модель
    protected $model = NULL;
    // имя контроллера
    protected $controller = NULL;
    // откуда загружать изображения
    protected $dir_upload_gallery = NULL;
    // параметры
    protected $params = NULL;

    public function before() {
        parent::before();
        $this->model = Model::factory('gallery');
        $this->controller = Request::current()->controller();
        $this->dir_upload_gallery = Kohana::$config->load('conf.dir_upload_gallery');
        $this->params = $this->request->param('params');
    }

    public function action_index() {

        // если нет параметров, выводим категории / папки
        if (empty($this->params)) {

            $pagination = Pagination::factory(array(
                        'total_items' => count($this->model->get_gcategories())
                    ))->route_params(array(
                'controller' => Request::current()->controller(),
                    //'params' => $this->request->param('params'),
            ));
            $items_per_page_gcats = Kohana::$config->load('conf.items_per_page_gcats');
            $pagination->items_per_page = empty($items_per_page_gcats) ? $pagination->items_per_page : $items_per_page_gcats;
            $offset = $pagination->offset;

            $gcategories = $this->model->get_gcategories(null, null, $pagination->items_per_page, $offset);

            $content = View::factory('index/' . $this->controller . '/index', array(
                        'gcategories' => $gcategories,
                        'path' => $this->dir_upload_gallery . '/categories',
                        'pagination' => $pagination,
            ));
            $this->template->title = 'Фотогалерея';
        } else {
            // отделная папка / категория по алиасу
            $gcategories = $this->model->get_gcategories(null, $this->params);

            $gcat_id = empty($gcategories[0]['gcat_id']) ? NULL : $gcategories[0]['gcat_id'];
            $gcat_name = empty($gcategories[0]['gcat_name']) ? NULL : $gcategories[0]['gcat_name'];
            $gcat_alias = empty($gcategories[0]['gcat_alias']) ? NULL : $gcategories[0]['gcat_alias'];

            $gallery = $this->model->get_gallery(null, array($gcat_id));

            if (empty($gallery)) {
                $content = View::factory('index/' . $this->controller . '/view', array(
                            'gallery' => array(),
                            'path' => $this->dir_upload_gallery,
                            'name' => '',
                ));
            } else {
                $content = View::factory('index/' . $this->controller . '/view', array(
                            'gallery' => $gallery[0],
                            'path' => $this->dir_upload_gallery,
                            'name' => $gcat_name,
                ));
            }
            if (!empty($gcategories[0]['gcat_title'])) {
                $this->template->title = $gcategories[0]['gcat_title'];
            }
            if (!empty($gcategories[0]['gcat_meta_k'])) {
                $this->template->meta_keywords = $gcategories[0]['gcat_meta_k'];
            }
            if (!empty($gcategories[0]['gcat_meta_d'])) {
                $this->template->meta_description = $gcategories[0]['gcat_meta_d'];
            }
        }
        //html::pr($gcategories, 1);
        $this->template->content = $content;
    }

}