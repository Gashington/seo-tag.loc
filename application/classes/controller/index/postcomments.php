<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Postcomments extends Controller_Index
{

    public function before()
    {

        if (isset($_POST)) {
            $post = Validation::factory($_POST);
            $post->rule('name', 'not_empty')
                ->rule('comment', 'not_empty')
                ->rules('captcha', array(array('not_empty'), array('Captcha::valid')))
                ->labels(array(
                    'name' => 'Имя',
                    'comment' => 'Комментарий',
                    'captcha' => 'Капча'
                ));
            if ($post->check()) {
                // если введнное пользователем имя уже существует
                if ($post['name'] != text::dsCrypt(Cookie::get('comment_user_name', ''), 1)
                    && Model::factory('comments')->is_name_exist($post['name'])
                ) {
                    echo '2';
                } // если все впорядке, добавляем комменти запоминаем имя пользователя в куки
                else {
                    $name = text::dsCrypt($post['name']);
                    Cookie::set('comment_user_name', $name);
                    Model::factory('comments')->add_comment($post, 'contents');
                    $this->_send_comment_mail($post['name'], $post['comment']);
                    echo '1';
                }
                die;
            } else {
                foreach ($post->errors('validation') as $v) {
                    echo $v . "\n";
                }
                die;
            }
        }
    }

    private function _send_comment_mail($name, $comment){
        $message = 'Добавлен комментарий на сайте ' . url::base() . "<br/>";
        $message .= "<b>Комментарий.</b> <br/>";
        $message .= 'Имя: ' . html::filter($name);
        $message .= '. Комментарий: ' . html::filter($comment);
        $this->_send_mail($message);
    }

}
