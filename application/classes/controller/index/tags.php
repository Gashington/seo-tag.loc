<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Контроллер отзывы
 */

class Controller_Index_Tags extends Controller_Index {

    private $tag = null;
    private $model = null;

    public function before() {
        $this->tag = $this->request->param('tag');
        $this->model =  Model::factory('tagscloud');
        $this->model->get_contents('php');

    }

    public function index() {
        echo '!';

        die;
    }
}