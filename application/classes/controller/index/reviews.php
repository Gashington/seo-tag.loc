<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Контроллер отзывы
 */

class Controller_Index_Reviews extends Controller_Index {

    private $mess = NULL;
    protected $errors = NULL;
    private $pagination;

    public function before() {
        parent::before();
        $count = Model::factory('reviews')->get_count_reviews();
        $pagination = Pagination::factory(array(
                    'total_items' => $count,
                ))->route_params(array(
            'controller' => Request::current()->controller(),
        ));

        $limit = $pagination->items_per_page;

        $offset = $pagination->offset;
        $this->pagination = $pagination;

        $this->all_reviews = Model::factory('reviews')->get_reviews($limit, $offset);
    }

    public function action_index() {

        if (isset($_POST['submit'])) {
            
            $post = Validation::factory($_POST);
            $post->rule('name', 'not_empty')
                    ->rule('more', 'not_empty')
                    ->rules('captcha', array(array('not_empty'), array('Captcha::valid')))
                    ->labels(array(
                        'name' => 'Ваше имя',
                        'more' => 'Ваш отзыв',
                        'captcha' => 'Капча'
            ));
            if ($post->check()) {
                $this->_send_mail('Добавлен отзыв в разделе "отзывы". Зайдите в админку для модерации.');
                $name = HTML::chars(trim($post['name']));
                $more = HTML::chars(trim($post['more']));

                Model::factory('reviews')->add_reviews(
                        $name, (int) Kohana::$config->load('conf.show_reviews'), $more
                );
                $this->request->redirect('reviews?ok');
            }
            $this->errors = $post->errors('validation');
        }

        $content = View::factory('index/reviews/index', array(
                    'all_reviews' => $this->all_reviews,
                    'pagination' => $this->pagination,
                    'mess' => $this->mess,
                    'captcha' => $this->captcha,
                ))->bind('post', $post);

        $this->template->title = 'Отзывы';
        $this->template->content = $content;
        $this->template->errors = $this->errors ? array($this->errors) : null;
    }

}