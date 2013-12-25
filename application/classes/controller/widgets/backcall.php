<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Виджет "Форма заказа"
 */

class Controller_Widgets_Backcall extends Controller_Widgets {

    // Шаблон виждета
    public $template = 'widgets/w_backcall';

    // здесь мы будем обращаться к модели для получения меню
    public function action_index() {
     
        //$servicesub = Model::factory('services')->get_services();
        //$this->template->servicesub = $servicesub;
        $this->template->errors = array();
        $this->template->mess = array();
        View::bind_global('post', $post);
      
        
        if (isset($_POST['submit']) && $_POST['submit'] == 'Заказать') {
          
            // антибот
            if (!empty($_POST['first_item']))
                die;

            $post = Validation::factory($_POST);
            $post->rule('name', 'not_empty')
                    //->rule('email', 'not_empty')
                    ->rule('tel', 'not_empty')
                    //->rule('email', 'email')
                    ->labels(array(
                        'name' => 'Имя',
                        //'email' => 'E-mail',
                        'tel' => 'Телефон'
                    ));
            if ($post->check()) {
                if (empty($this->site_info['mail_site'])){
                    $to = Kohana::$config->load('conf.mail');
                }
                else{
                    $to = $this->site_info['mail_site'];
                }

                $message = __('mail_backcall') . ' ' . url::base() . "<br/>";
                $message .= "<b>Данные пользователя.</b> <br/>";
                $message .= "Имя $post[name]. Телефон $post[tel]";
               
                if ($this->_send_mail($to, $message) == true) {
                    $this->template->mess = array('Сообщение отправлено!');
                }
            }
            $this->template->errors = $post->errors('validation');
        }
    }

}