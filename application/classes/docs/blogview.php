<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Блог отдельная страница
 */
class Docs_Blogview extends Docs_Docs {

    protected $errors = NULL;
    protected $model;

    public function show($obj, $params) {

        $model = $obj->get_model();

        $arr_alias = $model->get_arr_doc_alias($params);
        $all_cats = $model->get_all_cats($obj);
        $blog = $model->get_blogview($arr_alias['id'], $all_cats);
        if (empty($blog)) {
            return false;
        }
        $active_cat = $model->get_cat_active($arr_alias['alias_last']);

        $view = $model->get_view($active_cat) == '_index' ? '/view' : '/view' . $model->get_view($active_cat);
        $class = $model->get_css_class($active_cat);

        $comments_list = Model::factory('comments')->get_comments($arr_alias['id'], 'contents');
        $comment_form = View::factory('index/comments/form', array(
                    'id' => $arr_alias['id'],
                    'url' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                    'captcha' => $obj->captcha,
                    'cookie_user_name' => text::dsCrypt(Cookie::get('comment_user_name', ''), 1),
        ));
        $comments = View::factory('index/comments/index', array(
                    'comments' => $comments_list,
        ));

        $content = View::factory('index/' . Request::current()->controller() . $view, array(
                    'doc' => $blog,
                    'class' => $class,
                    'category' => $active_cat,
                    'comment_form' => $comment_form,
                    'comments' => $comments,
                    'next' => $model->get_next_id($blog['cont_id']),
                    'prev' => $model->get_prev_id($blog['cont_id']),
                    'more_url' => function($item, $alias = '') {
                foreach ($item as $v) {
                    $alias .= $v['cat_alias'] . '/';
                }
                return $alias;
            }
        ));
        $obj->template->content = $content;
        $obj->template->errors = $this->errors ? $this->errors : null;
        $obj->template->meta_keywords = $blog['cont_meta_k'];
        $obj->template->meta_description = $blog['cont_meta_d'];
        $obj->template->title = $blog['cont_title'];
        return true;
    }

}
