<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Блог
 */
class Docs_Blog extends Docs_Docs {
    
    protected $errors = NULL;
    
    /**
     * 
     * @param type $obj объект контроллера
     * @param type $params root
     * @return boolean
     */
    public function show($obj, $params) {
        
        $model = $obj->get_model();
        
        $order = empty($_GET['order']) ? NULL : new Docs_Order($_GET['order']);
               
        $arr_alias = $model->get_arr_doc_alias($params); 
          
        $active_cat = $model->get_cat_active($arr_alias['alias_last']);       
        $active_catid = $model->get_catid_active($active_cat); 
        // если нет активной категории,возвращаем false и редиректим на 404
        if(empty($active_cat)) return false;       
        $all_cats = $model->get_all_cats($obj);        
        $cats_id = $model->get_cats_daughter_id($all_cats, $active_catid);
        $pagination = $this->_get_obj_pagination($model->get_count_content($cats_id), $params);   
        $blogs = $model->get_blog($cats_id, $pagination, $all_cats, $order);      
        $view = $model->get_view($active_cat) == '_index' ? '/index' : '/index' . $model->get_view($active_cat);
        $class = $model->get_css_class($active_cat);

        //$comments_count = function($id){
           // return count(Model::factory('comments')->get_comments($id, 'contents'));
        //};
        
        $content = View::factory('index/' . Request::current()->controller() . $view, array(
                    'docs' => $blogs,
                    'pagination' => $pagination,
                    'class' => $class,
                    'category' => $active_cat,
                    'more_url' => function($item, $alias = '') {
                        foreach ($item as $v) {
                            $alias .= $v['cat_alias'] . '/';
                        }
                        return $alias;
                     },
                    //'comments_count' => $comments_count,
        ));
        $obj->template->content = $content;
        $obj->template->errors = $this->errors ? $this->errors : null;
        $obj->template->meta_keywords = $active_cat['cat_meta_k'];
        $obj->template->meta_description = $active_cat['cat_meta_d'];
        $obj->template->title = $active_cat['cat_title'];
        return true;
    }
    
    /**
     * Объект пагинатора
     * @param int $count количество материалов
     * @param object $obj текущий объект
     * @param string $params параметры url
     * @return type
     */
    private function _get_obj_pagination($count, $params) {
        $pagination = Pagination::factory(array(
                    'total_items' => $count
                ))->route_params(array(
            'controller' => Request::current()->controller(),
            'params' => $params,
        ));

        $items_per_page_docs = Kohana::$config->load('conf.items_per_page_docs');
        $pagination->items_per_page = empty($items_per_page_docs) ? $pagination->items_per_page : $items_per_page_docs;
        $n = empty($_COOKIE['items_per_page_news']) ? $pagination->items_per_page : (int) $_COOKIE['items_per_page_news'];
        $pagination->items_per_page = $n;

        return $pagination;
    }

}
