<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Поиск
 */
class Controller_Index_Search extends Controller_Index {
    
    /**
     * Минимальное количество слов для запроса
     * @var int
     */
    protected $min_word;

    public function before() {
        parent::before();
        // модель searchpages наследует searchdocs, a searchdocs - search 
        $this->model = Model::factory('searchpages');
        $this->controller = Request::current()->controller();
        $this->min_word = $this->model->get_min_word();
    }

    public function action_index() {

        $errors = array();
        $nodata = '';
        $search_docs = array();
        $search_pages = array();
        $serch_res = array();
        

        if (isset($_POST['submit'])) {

            $post = Validation::factory($_POST);

            $post->rule('search', 'not_empty')
                    ->rule('search', 'min_length', array(':value', $this->min_word))
                    ->labels(array(
                        'login' => 'введенное слово ',
            ));

            if ($post->check()) {
                $search = UTF8::trim(strip_tags($post['search']));
                $words = preg_split("/([^а-яёa-z\-\_@0-9]\)+)/ui", $search);
                
                // ищем по документам
                $search_docs = $this->model->get_search_docs($words, "`cont_body`,`cont_tiser`,`cont_name`");
                // ищем по статике
                $search_pages = $this->model->get_search_pages($words, "`name`,`content`");

                $serch_res = array_merge($search_docs, $search_pages);

                foreach ($serch_res as $r) {
                    $counts[] = $r['count'];
                }
                if (!empty($serch_res)) {
                    array_multisort($counts, SORT_DESC, $serch_res);
                }
                else
                    $serch_res = array();                
            }

            $errors = $post->errors('validation');
        }
        
        $content = View::factory('index/' . $this->controller . '/index', array(
                    'serch_res' => $serch_res,
                    'min_word' => $this->min_word,
        ))->bind('post', $post);
        // Выводим в шаблон
        $this->template->errors = $errors;
        $this->template->title = 'Результат поиска';
        $this->template->content = $content;
    }

}