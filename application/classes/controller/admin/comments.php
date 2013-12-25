<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Comments extends Controller_Admin {
    
    protected $errors = array();
    protected $mess = '';
    
    public function before() {
        parent::before();
        // Вывод в шаблон
        $this->template->title = 'Комментарии';
        $this->template->errors = $this->errors;
        $this->template->mess = $this->mess;
        $this->model = Model::factory('comments');
    }

    public function action_index() {
         
        $all_comments = $this->model->get_comments();
        $content = View::factory('admin/comments/index', array(
            'all_comments' => $all_comments,
        ));
        // Вывод в шаблон
        $this->template->content = array($content);
    }


    public function action_edit() {

        $id = (int) $this->request->param('params');     
        $comments = $this->model->get_comments(NULL, NULL, $id);      
 
        if (isset($_POST['submit'])) {
            $post = Validation::factory($_POST);
            $post->rule('name', 'not_empty')
                    ->rule('comment', 'not_empty')
                    ->labels(array(
                        'name' => 'Имя',
                        'comment' => 'Комментарий',
            ));

            if($post->check()){
                $this->model->edit_comment($id, $post);
                $this->request->redirect('admin/comments');
            }
            $this->errors = $post->errors('validation');
        }
        $content = View::factory('admin/comments/edit',array(
            'comment' => $comments[0],
        ))->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать';
    }
    
    public function action_delete() {
        $id = (int) $this->request->param('params');
        $this->model->delete_comment($id);
        $this->request->redirect('admin/comments');
    }
    
    public function action_removechecked() {
        $check_comments = empty($_POST['check_comment']) ? array() : $_POST['check_comment'];
        //html::pr($check_pages,1);
        foreach ($check_comments as $k => $v) {
            $k = (int) $k;
            $this->model->delete_comment($k);
        }
        $this->request->redirect('admin/comments');
    }
    
    
}