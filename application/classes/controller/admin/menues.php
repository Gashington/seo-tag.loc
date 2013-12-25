<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Menues extends Controller_Admin {

    protected $errors = array();
    protected $mess = '';
    protected $model;
    protected $controller;
    protected $id;
    protected $all_pages;
    protected $all_categories;
    protected $li;

    public function before() {
        parent::before();
        // Вывод в шаблон
        $this->template->title = 'Управление меню';
        $this->template->errors = $this->errors;
        $this->template->mess = $this->mess;
        $this->model = Model::factory('menues');
        $this->controller = Request::current()->controller();
        $this->id = (int) $this->request->param('params');
        $this->all_pages = Model::factory('pages')->get_pages();
        $this->all_categories = Model::factory('docscontents')->get_categories();
        // нужно для отображения в админке всех блогов
        $this->li = Model::factory('docscontents')->get_li_categories($this->all_categories, 'docs');
    }

    public function action_index() {

        if (!empty($_GET['err'])) {
            $this->template->errors = array($_GET['err']);
        }

        $menus_types = $this->model->get_menu_types();

        if (empty($menus_types)) {
            $menus_types = array();
            $menus = array();
        }
        
        foreach ($menus_types as $k => $type) {
            $menu = $this->model->get_menu(null, null, null, $type['menut_id']);
            $menus[$k]['type_name'] = $type['menut_name'];
            $menus[$k]['type_h'] = $type['menut_h'];
            $menus[$k]['type_alias'] = $type['menut_alias'];
            $menus[$k]['type_id'] = $type['menut_id'];
            $menus[$k]['type_descr'] = $type['menut_descr'];
            $menus[$k]['type_order'] = $type['menut_order'];
            $menus[$k]['menues'] = $menu;
            $menus[$k]['tree'] = $this->model->get_li_menu_admin($menus[$k]['menues'], 0);
        }

        $content = View::factory('admin/' . $this->controller . '/index', array(
                    'menus' => $menus,
                    'controller' => $this->controller
        ));
        // Вывод в шаблон
        $this->template->content = array($content);
    }

    public function action_edit() {

        $pages_links = array();
        $menu_id = $this->id;      
        $menus_detailed = $this->model->get_menu(null, $menu_id);
        
        //html::pr($menus_detailed,1);
        
        $selectid = empty ($menus_detailed[0]['menu_parant_id']) ? 0 : (int)$menus_detailed[0]['menu_parant_id'];
        
        $menu_type = $menus_detailed[0]['menut_alias'];
        $list = $this->model->get_menu(null, null, $menu_type);
        $menus_options = $this->model->get_option_menu($list, 0, 0, $selectid);

        foreach ($this->all_pages as $k => $page) {
            $pages_links[$k]['alias'] = $page['alias'];
            $pages_links[$k]['name'] = $page['name'];
            $pages_links[$k]['content'] = $page['content'];
        }

        if (isset($_POST['submit'])) {
            // здесь $params = id страницы

            $post = $this->validate_menu();

            if ($post->check()) {
                //если значение из формы совпадают с id переданного парарамтра, то оставляем как есть          
                $parant_id = ($post['parant_id'] == $menu_id) ? $menus_detailed[0]['menu_parant_id'] : $post['parant_id'];

                $this->model->update_menus(
                        $post, 
                        $parant_id, 
                        $menu_id
                );
                $this->request->redirect('admin/' . $this->controller . '/index');
            }
            $this->errors = $post->errors('validation');
        }

        $content = View::factory('admin/' . $this->controller . '/edit', array(
                    'menus' => $menus_detailed[0],
                    'menus_options' => $menus_options,
                    'controller' => $this->controller,
                    'pages_links' => $pages_links,
                    'cats' => $this->li,
                ))
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать';
    }

    public function action_add() {
        $menu_alias = $this->request->param('params');
        $menu_types = $this->model->get_menu_types($menu_alias);
        $menu_menut_id = $menu_types[0]['menut_id'];
        $list = $this->model->get_menu(null, null, $menu_alias);
        //$menus_options = $this->model->get_menu_options(Tree::getInstance(), $menus, $id = 0, $k = 0, $selectedid = NULL);
        $menus_options = $this->model->get_option_menu($list, 0, 0, NULL);

        $all_pages = Model::factory('pages')->get_pages();

        foreach ($all_pages as $k => $page) {
            $pages_links[$k]['alias'] = $page['alias'];
            $pages_links[$k]['name'] = $page['name'];
            $pages_links[$k]['content'] = $page['content'];
        }

        if (!empty($_POST['submit'])) {

            $post = $this->validate_menu();

            if ($post->check()) {
                $this->model->add_menu($post);
                $this->request->redirect('admin/' . $this->controller . '/index');
            }

            $this->errors = $post->errors('validation');
        }
        $content = View::factory('admin/' . $this->controller . '/add', array(
                    'menus_options' => $menus_options,
                    'menu_alias' => $menu_alias,
                    'menu_menut_id' => $menu_menut_id,
                    'controller' => $this->controller,
                    'pages_links' => $pages_links,
                    'cats' => $this->li,
                ))->bind('post', $post);


        // Вывод в шаблон
        $this->template->content = array($content);
        $this->template->title .= ' :: Добавить';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_addtype() {
        if (!empty($_POST['submit'])) {

            $post = $this->validate_menutype();

            if ($post->check()) {

                $this->model->add_menutype($post);
                $this->request->redirect('admin/' . $this->controller . '/index');
            }

            $this->errors = $post->errors('validation');
        }
        $content = View::factory('admin/' . $this->controller . '/addtype', array(
                    'controller' => $this->controller
                ))->bind('post', $post);


        // Вывод в шаблон
        $this->template->content = array($content);
        $this->template->title .= ' :: Добавить';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_delete() {

        $res = $this->model->delete_menu($this->id);
        $err1 = 'Нельзя удалить родительский пункт меню!';
        switch ($res) {
            case 2 :
                $this->request->redirect('admin/' . $this->controller . '/?err=' . $err1);
                break;
            default :
                $this->request->redirect('admin/' . $this->controller);
        }
    }

    public function action_deltype() {
        $res = $this->model->del_type($this->id);
        $this->request->redirect('admin/' . $this->controller);
    }

    public function action_edittype() {
        $id = (int) $this->request->param('params');
        $menu_types = $this->model->get_menu_types(null, $this->id);
        $menu_type = $menu_types[0];

        if (isset($_POST['submit'])) {
            $post = $this->validate_menutype();
            if ($post->check()) {
                $this->model->update_menustype($post, $this->id);
                $this->request->redirect('admin/' . $this->controller . '/index');
            }
            $this->errors = $post->errors('validation');
        }

        $content = View::factory('admin/' . $this->controller . '/edittype', array(
                    'menu_type' => $menu_type,
                    'controller' => $this->controller
                ))
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать';
    }

    /**
     * Валидация пунктов меню
     */
    protected function validate_menu() {
        $post = Validation::factory($_POST);
        $post->rule('name', 'not_empty')
                ->rule('alias', 'not_empty')
                ->rule('menut_id', 'digit')
                ->rule('url', 'regex', array(':value', '/^[a-z0-9\-\/\?\=\.]++$/iD'))
                ->rule('alias', 'regex', array(':value', '/^[a-z0-9\-\/]++$/iD'))
                ->labels(array(
                    'name' => 'Название',
                    'url' => 'Ссылка, указание на контроллер',
                    'alias' => 'Alias меню',
                    'menut_id' => 'id типа меню'
        ));
        return $post;
    }

    /**
     * Валидация типа  меню
     */
    protected function validate_menutype() {
        $post = Validation::factory($_POST);
        $post->rule('name', 'not_empty')
                ->rule('alias', 'not_empty')
                ->rule('alias', 'regex', array(':value', '/^[a-z0-9\-\/]++$/iD'))
                ->rule('alias', array($this->model, 'unique_alias'), array($post['alias'], $this->id))
                ->labels(array(
                    'name' => 'Название',
                    'alias' => 'Alias меню',
        ));
        return $post;
    }

}