<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Robots extends Controller_Admin {

    protected $errors = array();
    protected $mess = '';

    public function action_index() {

        $robots = file_get_contents(url::root() . '/robots.txt');

        if (isset($_POST['submit'])) {
            
                $robots = $_POST['robots'];
                file_put_contents(url::root() . '/robots.txt', $robots);
                $this->request->redirect('admin/robots');
            
            $this->errors = $post->errors('validation');
        }

        $content = View::factory('admin/robots/edit', array(
                    'robots' => $robots,
                ))
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title = 'Редактировать robots.txt';
    }

}

?>
