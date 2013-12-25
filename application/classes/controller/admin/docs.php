<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Docs extends Controller_Admin_Categories {

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
        $this->template->title = 'Документы';
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
        
        $order_li = $this->model->get_tree_fororder($this->all_categories, url::base() . 'admin/docs');
              
        $active_cat = $this->model->get_cat_active($this->arr_alias['alias_last']);       
        $active_catid = $this->model->get_catid_active($active_cat);              
        $all_cats = $this->model->get_all_cats($this);        
        $cats_id = $this->model->get_cats_daughter_id($all_cats, $active_catid);    
        $pagination = $this->_get_obj_pagination($this->model->get_count_content($cats_id), $this->params);  
        $blogs = $this->model->get_blog($cats_id, $pagination, $all_cats); 

        $content = View::factory('admin/' . $this->controller . '/index', array(
                    'all_blogs' => $blogs,
                    'order_li' => $order_li,
                    'pagination' => $pagination,
                    'count_view_default' => $pagination->n,
                    'alias' => $this->arr_alias['alias_str'],
                    'controller' => $this->controller,
        ));
        $this->template->content = array($content);
    }

    public function action_edit() {

        $docs = $this->model->get_contents(NULL, $this->arr_alias['id']);

        //html::pr($docs,1);
        $cont_cat_id = $docs[0]['cont_cat_id'];

        $img = !empty($docs[0]['cont_img']) ? $docs[0]['cont_img'] : null;

        if (isset($_POST['submit'])) {

            $post = $this->post_validation();
            $upload = $this->img_validation($_FILES);

            if ($post->check() && $upload->check()) {

                $img_uload = $this->_upload_preview_img($_FILES, $this->dir_upload_preview, $this->w, $this->h);

                if (empty($img_uload)) {
                    $img_uload = $img;
                } else { 
                    $this->model->unlink_preview($this->dir_upload_preview , $img); 
                }
                $this->model->edit_docs($post, $this->arr_alias['id'], $img_uload);
                $this->request->redirect('admin/' . $this->controller . '/index/' . $this->arr_alias['alias_str']);
            }
            $upload_err = $upload->errors('validation');
            $post_err = $post->errors('validation');
            $this->errors = array_merge($upload_err, $post_err);
        }
        $cats = $this->model->get_tree_options($this->all_categories, 0, 0, $cont_cat_id);

        $content = View::factory('admin/' . $this->controller . '/edit', array(
                    'blogs' => $docs[0],
                    'cats' => $cats,
                    'alias' => $this->arr_alias['alias_str'],
                    'controller' => $this->controller,
                    'img' => $img,
                ))
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать запись';
    }

    public function action_add() {
        
        $id = empty($_POST['cats']) ? null : (int)$_POST['cats'];
        $cats = $this->model->get_tree_options($this->all_categories, 0 , 0,  $id);

        if (!empty($this->arr_alias['id']))
            $this->mess = $this->arr_alias['id'];

        if (!empty($_POST['submit'])) {
            // валидация post данных и изображения (изображения может не быть)
            $post = $this->post_validation();
            $upload = $this->img_validation();

            if ($post->check() && $upload->check()) {

                // загрузка изображения
                $img = $this->_upload_preview_img($_FILES, $this->dir_upload_preview, $this->w, $this->h);
                $img = !empty($img) ? $img : '';

                $this->model->add_docs($post, $img);
                $this->request->redirect('admin/' . $this->controller . '/index/' . $this->arr_alias['alias_str']);
            }
            // собираем ошибки
            $upload_err = $upload->errors('validation');
            $post_err = $post->errors('validation');
            $this->errors = array_merge($upload_err, $post_err);
        }

        $content = View::factory('admin/' . $this->controller . '/add', array(
                    'cats' => $cats,
                    'alias' => $this->arr_alias['alias_str'],
                    'controller' => $this->controller,
                ))
                //->bind('errors', $errors)
                ->bind('post', $post);
        $this->template->content = array($content);
        $this->template->title .= ' :: Добавить';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_delete() {
        $this->model->delete_docs($this->arr_alias['id']);
        $this->request->redirect('admin/' . $this->controller . '/index/' . $this->arr_alias['alias_str']);
    }

    /**
     * Удалить превью
     */
    public function action_delpreview() {
        $dir_upload = Kohana::$config->load('conf.dir_upload_preview');       
        $result = $docs = $this->model->get_contents(NULL, $this->arr_alias['id']);
        $this->model->unlink_preview($dir_upload, $result[0]['cont_img']);
        $this->model->delpreview_doc($this->arr_alias['id']);       
        $this->request->redirect('admin/' . $this->controller . '/edit/' . $this->arr_alias['id']);
    }

    /**
     * AJAX сортировка материалов
     */
    public function action_editorder() {

        $cont_id = $_POST['cont_id'];
        $cont_ids = explode(',', $cont_id);

        $cont_order = $_POST['cont_order'];
        $cont_orders = explode(',', $cont_order);

        if ($this->model->edit_docs_order($cont_ids, $cont_orders))
            echo ('Порядок изменен');
        die;
    }

    /**
     * Удаление выбранных материалов
     */
    public function action_removechecked() {
        $check_docs = empty($_POST['check_docs']) ? array() : $_POST['check_docs'];
        //html::pr($check_docs,1);
        foreach ($check_docs as $k => $v) {
            $k = (int) $k;
            $this->model->delete_docs($k);
        }
        $this->request->redirect('admin/' . $this->controller . '/index/' . $this->arr_alias['alias_str']);
    }

    /**
     * Получение объекта пагинации
     * @return obj
     */
    protected function _get_obj_pagination($count, $params) {
        $pagination = Pagination::factory(array(
                    'total_items' => $count
                ))->route_params(array(
            'controller' => $this->controller,
            'action' => Request::initial()->action(),
            'params' => $this->arr_alias['alias_str'],
        ));
        
        $items_per_page_docs = Kohana::$config->load('conf.items_per_page_docs_admin');     
        $pagination->items_per_page = empty($items_per_page_docs) ? $pagination->items_per_page : $items_per_page_docs;
        $n = empty($_COOKIE['items_per_page_docs']) ? $pagination->items_per_page : (int) $_COOKIE['items_per_page_docs'];
        $items_per_page = $pagination->items_per_page = $n;
        $pagination->n = $n;
        return $pagination;
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

    

    

}

