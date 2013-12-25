<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Categories extends Controller_Admin {

    /**
     * Алиас разбитый на массив без id
     * @var arra() 
     */
    protected $arr_alias = array();

   

    /**
     * Модель
     * @var mixed 
     */
    protected $model = NULL;

    /**
     * Разделитель алиасов
     * @var string 
     */
    protected $n = '/';

    /**
     * Имя контроллера
     * @var string 
     */
    protected $controller = NULL;
    // ошибки и сообщения
    protected $errors = array();
    protected $mess = '';

    /**
     * Все категории
     * @var array
     */
    protected $all_categories = array();
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
        $this->template->title = 'Категории блогов';
        $this->controller = Request::current()->controller();
        $this->model = Model::factory('docscontents');
        $this->dir_upload_preview = Kohana::$config->load('conf.dir_upload_preview');
        $this->w = Kohana::$config->load("conf.img_preview_doc_w");
        $this->h = Kohana::$config->load("conf.img_preview_doc_h");    
        $this->all_categories = $this->model->get_categories();
        $this->params = $this->request->param('params');
        $this->arr_alias = $this->model->get_arr_doc_alias($this->params);
    }

    public function action_index() {

        if (!empty($_GET['err'])) {
            $this->template->errors = array($_GET['err']);
        }        
              
        $active_cat = $this->model->get_cat_active($this->arr_alias['alias_last']);       
        $active_catid = $this->model->get_catid_active($active_cat);              
        $all_cats = $this->model->get_all_cats($this);        
        $cats_id = $this->model->get_cats_daughter_id($all_cats, $active_catid);     
        $table = $this->model->get_table_admincategories($this->all_categories,  url::base() . 'admin/categories');       

        $content = View::factory('admin/' . $this->controller . '/index', array(
                    'cats' => $table,                   
                    'controller' => $this->controller,
        ));
        $this->template->content = array($content);
    }

    

    public function action_add() {
        
        $id = empty($_POST['cats']) ? null : (int)$_POST['cats'];
        $cats_options = $this->model->get_tree_options($this->all_categories, 0 , 0,  $id);
        // поучить вьюсы документов
        $docs_views_list = $this->get_docs_views_list('index');

        if (!empty($_POST['submit'])) {

            $upload = $this->img_validation();
            $post = Validation::factory($_POST);
            $post->rule('name', 'not_empty')
                    ->rule('alias', 'not_empty')
                    ->rule('alias', 'regex', array(':value', '/^[a-z0-9\-]++$/iD'))
                    ->rule('alias', array($this->model, 'unique_alias'))
                    ->labels(array(
                        'name' => 'Название',
                        'alias' => 'Алиас',
            ));

            if ($post->check() && $upload->check()) {

                // загрузка изображения
                $img = $this->_upload_preview_img($_FILES, $this->dir_upload_preview, $this->w, $this->h);
                $img = !empty($img) ? $img : '';
                $this->model->add_cat($post, $img);
                $this->request->redirect('admin/' . $this->controller);
            }

            // собираем ошибки
            $upload_err = $upload->errors('validation');
            $post_err = $post->errors('validation');
            $this->errors = array_merge($upload_err, $post_err);
        }

        $content = View::factory('admin/' . $this->controller . '/add', array(                 
                    'cats_options' => $cats_options,
                    'controller' => $this->controller,
                    'docs_views_list' => $docs_views_list,
                ))
                //->bind('errors', $errors)
                ->bind('post', $post);

        // Вывод в шаблон
        $this->template->content = array($content);
        $this->template->title .= ' :: Добавить категорию';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_edit() {

        $cats = $this->model->get_categories($this->arr_alias['id']);
        $img = !empty($cats[0]['cat_img']) ? $cats[0]['cat_img'] : null;
        // узнаем id родительской категории
        $select_id = empty($cats[0]['cat_parent_id']) ? 0 : (int) $cats[0]['cat_parent_id'];
        $cats_options = $this->model->get_tree_options($this->all_categories, 0, 0, $select_id);
        $docs_views_list = $this->get_docs_views_list('index');

        if (isset($_POST['submit'])) {

            $post = Validation::factory($_POST);
            $upload = $this->img_validation($_FILES);

            $post->rule('name', 'not_empty')
                    ->rule('alias', 'not_empty')
                    ->rule('alias', 'regex', array(':value', '/^[a-z0-9\-]++$/iD'))
                    ->rule('alias', array($this->model, 'unique_alias'), array($post['alias'], $this->arr_alias['id']))
                    ->labels(array(
                        'name' => 'Название',
                        'alias' => 'Алиас',
            ));

            if ($post->check() && $upload->check()) {

                $img_uload = $this->_upload_preview_img($_FILES, $this->dir_upload_preview, $this->w, $this->h);

                if (empty($img_uload)) {
                    $img_uload = $img;
                } else {                   
                    $this->model->unlink_preview($this->dir_upload_preview , $img); 
                }

                $this->model->edit_cat($this->arr_alias['id'], $post, $img_uload);
                $this->request->redirect('admin/' . $this->controller);
            }
            $upload_err = $upload->errors('validation');
            $post_err = $post->errors('validation');
            $this->errors = array_merge($upload_err, $post_err);
        }
        $content = View::factory('admin/' . $this->controller . '/edit', array(
                    'cats' => $cats[0],
                    'cats_options' => $cats_options,
                    'controller' => $this->controller,
                    'docs_views_list' => $docs_views_list,
                ))
                //->bind('errors', $errors)
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать категорию';
    }

    public function action_delete() {
        $res = $this->model->delete_cat($this->arr_alias['id']);
        $err1 = 'Нельзя удалить родительскую категорию!';
        $err2 = 'Нельзя удалить категорию, если к ней привязаны материалы!';
        switch ($res) {
            case 2 :
                $this->request->redirect('admin/' . $this->controller  . '/?err=' . $err1);
                break;
            case 3 :
                $this->request->redirect('admin/' . $this->controller  . '/?err=' . $err2);
                break;
            default :
                $this->request->redirect('admin/' . $this->controller);
        }
    }

    /**
     * 
     * @param string $prefix префикс вида (view и index)
     * @return array Массив видов с заданным префиксом
     */
    private function get_docs_views_list($prefix = 'index') {
        $views_list_new = array();
        $views_list = scandir(url::root() . '/application/views/index/docs/');
        foreach ($views_list as $k => $v) {
            if ($v != '..' && $v != '.' && strpos($v, $prefix) !== false) {
                $v = str_replace('.php', '', $v);
                $v = str_replace($prefix . '_', '', $v);
                $views_list_new[] = $v;
            }
        }
        return $views_list_new;
    }

    /**
     * Валидация изображений слайдера
     * @param array $_FILES
     * @return object
     */
    protected function img_validation() {
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

    /**
     * Валидация post данных
     * @return object
     */
    protected function post_validation() {
        $post = Validation::factory($_POST);
        $post->rule('name', 'not_empty')
                ->rule('cats', 'digit')
                ->labels(array(
                    'name' => 'Название',
                    'cats' => 'Категории',
        ));
        return $post;
    }
    
    /**
     * Удалить превью
     */
    public function action_delpreview() {
        $dir_upload = Kohana::$config->load('conf.dir_upload_preview');       
        $result = $this->model->get_categories($this->arr_alias['id']);
        $this->model->unlink_preview($dir_upload, $result[0]['cat_img']);
        $this->model->delpreview_category($this->arr_alias['id']);       
        $this->request->redirect('admin/' . $this->controller . '/edit/' . $this->arr_alias['id']);
    }
    
    

}

