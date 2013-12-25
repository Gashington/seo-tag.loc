<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Contact extends Controller_Index {

    private $mess = NULL;
    protected $errors = NULL;
    protected $page;
    // контент с картой от гула или яндекса
    protected $chart;
    protected $map;

    public function before() {
        parent::before();
        // текстовая страница с контактами
        if (!$this->page = $this->cache->get('cache_contacts')) {
            $this->page = Model::factory('pages')->get_one_page('contact');
            $this->cache->set('cache_contacts', $this->page);
        }
        // текстовая страница с кодом карты сайта 
        if (!$this->map = $this->cache->get('cache_yandexmapping')) {
            $this->map = Model::factory('pages')->get_one_page('yandexmapping');
            $this->cache->set('cache_yandexmapping', $this->map);
        }
    }

    public function action_index() {
        
        if (isset($_POST['submit'])) {
            
            $post = Validation::factory($_POST);
            
            $post->rule('name', 'not_empty')
                    //->rule('tel', 'not_empty')
                    //->rule('email', 'not_empty')
                    ->rule('email', 'email')
                    ->rule('more', 'not_empty')
                    ->rules('captcha', array(array('not_empty'), array('Captcha::valid')))
                    ->labels(array(
                        'name' => 'Имя',
                        'email' => 'E-mail',
                        'more' => 'Сообщение',
                        //'tel' => 'Телефон',
                        'captcha' => 'Капча'
            ));

            if ($post->check()) {
                $message = __('mail_contact') . ' ' . url::base() . "<br/>";
                $message .= "<b>Данные пользователя.</b> <br/>";
                $message .= 'Имя: ' . html::filter($post['name']);
                $message .= '. E-mail: ' . html::filter($post['email']); 
                //$message .= '. Телефон: ' . html::filter($post['tel']);
                $message .= '. Комментарий: ' . html::filter($post['more']);               
                // res возвращает при удаче Message Sent, при ошибке - текст ошибки
                $res = $this->_send_mail($message);

                if ($res == "Message Sent") {
                    $this->request->redirect('contact?mess=ok');
                } else {
                    $this->errors = array($res);
                }
            } else {
                $this->errors = $post->errors('validation');
            }
        }

        if (!empty($_GET['mess']) && $_GET['mess'] == 'ok') {
            $this->mess = __('contact_msg');
        }
        $content = View::factory('index/contacts/view', array(
                    'mess' => $this->mess,
                    'page' => $this->page,
                    'map' => $this->map,
                    'captcha' => $this->captcha,
            
                ))->bind('post', $post);
        // Выводим в шаблон
        //$this->breadcrumbs[] = array('url' => '', 'name' => 'Контакты');
        $this->template->content = $content;
        //$this->template->breadcrumbs = $this->breadcrumbs;
        $this->template->title = $this->page['title'];
        $this->template->meta_keywords = $this->page['meta_k'];
        $this->template->meta_description = $this->page['meta_d'];
        $this->template->errors = $this->errors ? $this->errors : null;
    }

}
