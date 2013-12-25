<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Reviews extends Controller_Admin {
    
    protected $errors = array();
    protected $mess = '';
    
    public function before() {
        parent::before();

        // Вывод в шаблон
        //$this->template->submenu = Widget::load('menupages');
        $this->template->title = 'Отзывы';
        $this->template->errors = $this->errors;
        $this->template->mess = $this->mess;
        $this->model = Model::factory('reviews');
    }

    public function action_index() {
         
        $all_reviews = $this->model->get_reviews();
        $content = View::factory('admin/reviews/index', array(
            'all_reviews' => $all_reviews,
        ));
        // Вывод в шаблон
        $this->template->content = array($content);
    }

    public function action_edit() {

        $id = (int) $this->request->param('params'); 
        $reviews = $this->model->get_one_reviews($id);    

        if (isset($_POST['submit'])) {
            $post = Validation::factory($_POST);
            $post->rule('name', 'not_empty')
                 ->rule('tiser', 'not_empty')
                 ->rule('descr', 'min_length', array(':value', '10'))
                 ->labels(array(
                     'name' => 'Имя', 
                     'tiser' => 'Отзыв',
                     'descr' => 'Ответ'
                 ));

            if($post->check()){
                $reviews = Arr::extract($_POST, array(
                    'name',             
                    'show', 
                    'tiser', 
                    'descr'));
                $this->model->update_reviews(
                    $id,
                    $reviews['name'],
                    $reviews['show'], 
                    $reviews['tiser'], 
                    $reviews['descr']
                );
                $this->request->redirect('admin/reviews/');
            }
            $this->errors = $post->errors('validation');
        }
        $content = View::factory('admin/reviews/edit',array(
            'reviews' => $reviews,
        ))
                //->bind('errors', $errors)
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать';
    }
    
    public function action_add() {
        
        if (isset($_POST['submit'])) {
            $post = Validation::factory($_POST);
            $post->rule('name', 'not_empty')
                 ->rule('tiser', 'not_empty')
                 ->rule('descr', 'min_length', array(':value', '10'))
                 ->labels(array(
                     'name' => 'Имя', 
                     'tiser' => 'Отзыв',
                     'descr' => 'Ответ'
                 ));

            if($post->check()){
                $reviews = Arr::extract($_POST, array(
                    'name',
                    'show', 
                    'tiser', 
                    'descr'));
                $this->model->add_reviews(
                    $reviews['name'],
                    $reviews['show'], 
                    $reviews['tiser'], 
                    $reviews['descr']
                );
                $this->request->redirect('admin/reviews/');
            }
            $this->errors = $post->errors('validation');
        }
        $content = View::factory('admin/reviews/add'
        )
                //->bind('errors', $errors)
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Добавить';
    }
    
    public function action_delete() {
        $id = (int) $this->request->param('params');
        $this->model->delete_reviews($id);
        $this->request->redirect('admin/reviews');
    }
    
    public function action_removechecked() {
        //html::pr($_POST,1);
        $check_reviews = empty($_POST['check_review']) ? array() : $_POST['check_review'];
        //html::pr($check_pages,1);
        foreach ($check_reviews as $k => $v) {
            $k = (int) $k;
            $this->model->delete_reviews($k);
        }
        $this->request->redirect('admin/reviews');
    }
    
    
}