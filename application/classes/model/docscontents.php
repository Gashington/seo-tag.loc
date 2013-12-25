<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Docscontents extends Model_Docscategories {

    /**
     * Название таблицы контента
     * @var type string
     */
    private $tbl_name_contents = 'contents';

    /**
     * Выводит материалы
     * @param array $cats_daughter
     * @param int $id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_contents($cats_daughter = array(), $id = NULL, $limit = NULL, $offset = NULL, $order = NULL) {

        $limit = (int) $limit;
        $offset = (int) $offset;

        //url::pr($cats_daughter,1);
        $query = DB::select()->from($this->tbl_name_contents)->where('cont_id', '!=', NULL);

        if (!empty($cats_daughter)) {
            $query->and_where('cont_cat_id', 'IN', $cats_daughter);
        }

        if (!empty($id)) {
            $query->and_where('cont_id', '=', $id);
        }

        if (!Auth::instance()->logged_in('admin')) {
            $query->and_where('cont_show', '=', '1');
        }

        if ($limit != 0) {
            $query->limit($limit)->offset($offset);
        }
        if (!empty($order)) {
            list($name, $type) = $order->get_order_data();
            $query->order_by($name, $type);
        } else {
            $query->order_by('cont_order')->order_by('cont_id', 'DESC');
        }

        return $query->execute()->as_array();
    }
    
    public function next_id_content($id) {
        $query = DB::select('cont_id')->from($this->tbl_name_contents)->where('cont_id', '>', $id);
        $query->order_by('cont_id', 'ASC');
        $query->limit(1);
        $result = $query->execute()->as_array();
        return empty($result[0]['cont_id']) ? NULL : $result[0]['cont_id'];
    }

    public function prev_id_content($id) {
        $query = DB::select('cont_id')->from($this->tbl_name_contents)->where('cont_id', '<', $id);
        $query->limit(1);
        $query->order_by('cont_id', 'DESC');
        $result = $query->execute()->as_array();
        return empty($result[0]['cont_id']) ? NULL : $result[0]['cont_id'];
    }



    /**
     * Товар с массивом категорий и сопутствующих товаров
     * @return array
     */
    public function get_total_contents(array $docs, array $all_categories) {
        foreach ($docs as $k => $v) {
            $arr = $this->get_parent($all_categories, $v['cont_cat_id']);
            $docs[$k]['cats'] = array_reverse($arr);
        }
        return $docs;
    }
     
    public function get_count_content(array $cats_id) {
        $arr = $this->get_contents($cats_id);
        return empty($arr) ? 0 : count($arr);
    }

    public function get_blog(array $cats_id, $pagination, array $all_cats, $order = NULL) {
        $docs = $this->get_contents($cats_id, NULL, $pagination->items_per_page, $pagination->offset, $order);
        $total_docs = $this->get_total_contents($docs, $all_cats);
        return empty($total_docs) ? array() : $total_docs;
    }

    public function get_blogview($id, array $all_cats) {
        $docs = $this->get_contents(NULL, $id);
        $total_docs = $this->get_total_contents($docs, $all_cats);
        return empty($total_docs) ? array() : $total_docs[0];
    }
    
    public function get_next_id($id) {
        if (empty($id))
            return NULL;
        return $this->next_id_content($id);
    }

    public function get_prev_id($id) {
        if (empty($id))
            return NULL;
        return $this->prev_id_content($id);
    }

    /**
     * Редактирование документа
     * @param type $post
     * @param type $id
     * @param type $img
     * @return type
     */
    public function edit_docs($post, $id, $img) {
        $date = html::mktime_from_input_date($post['date']);
        $arr = array(
            'cont_name' => $post['name'],
            'cont_title' => $post['title'],
            'cont_meta_d' => $post['meta_d'],
            'cont_meta_k' => $post['meta_k'],
            'cont_show' => $post['show'],
            'cont_tiser' => $post['tiser'],
            'cont_body' => $post['body'],
            'cont_cat_id' => $post['cats'],
            'cont_img' => $img,
            'cont_main' => $post['main'],
            'cont_date' => $date,
        );
        if (empty($img)) {
            unset($arr['cont_img']);
        }
        $query = DB::update($this->tbl_name_contents)->set($arr)->where('cont_id', '=', $id);
        return $query->execute();
    }

    /**
     * Добавление материала
     * @param type $post
     * @param type $img
     * @return type
     */
    public function add_docs($post, $img) {

        $date = html::mktime_from_input_date($post['date']);

        $query = DB::insert($this->tbl_name_contents, array(
                    'cont_name',
                    'cont_title',
                    'cont_meta_k',
                    'cont_meta_d',
                    'cont_show',
                    'cont_tiser',
                    'cont_body',
                    'cont_cat_id',
                    'cont_date',
                    'cont_img',
                    'cont_main',
                ))->values(array(
            $post['name'],
            empty($post['title']) ? $post['name'] : $post['title'],
            $post['meta_k'],
            $post['meta_d'],
            $post['show'],
            $post['tiser'],
            $post['body'],
            $post['cats'],
            $date,
            $img,
            $post['main'],
        ));

        return $query->execute();
    }

    /**
     * Удаление документа
     * @param type $id
     * @return type
     */
    public function delete_docs($id) {

        $dir_upload = Kohana::$config->load('conf.dir_upload_preview');

        $query = DB::select()->from($this->tbl_name_contents)->where('cont_id', '=', $id)->limit(1);
        $result = $query->execute()->as_array();
        $img = $result[0]['cont_img'];
        // удаляем картинки из превью      
        $this->unlink_preview($dir_upload , $img); 
        // удаляем картики из контента!
        html::del_imgs_from_content($result[0]['cont_tiser']);
        html::del_imgs_from_content($result[0]['cont_body']);
        $query = DB::delete($this->tbl_name_contents)->where('cont_id', '=', $id)->limit(1);
        return $query->execute();
    }
    
    
    /**
     * Удаление превью
     * @param int $id
     * @return void
     */
    public function delpreview_doc($id){  
        $query = DB::update($this->tbl_name_contents)->set(
                        array('cont_img' => '')
                )->where('cont_id', '=', $id);

        return $query->execute();
    }

    /**
     * Сортировка материалов
     * @param array $cont_ids
     * @param array $cont_orders
     * @return boolean
     */
    public function edit_docs_order($cont_ids, $cont_orders) {
        foreach ($cont_ids as $k => $v) {
            $query = DB::update($this->tbl_name_contents)->set(array('cont_order' => $cont_orders[$k]))->where('cont_id', '=', $v)->execute();
        }
        return true;
    }

    /**
     * Отбражение документов на главной
     * @return array
     */
    public function get_main_contents() {
        $query = DB::select()->from($this->tbl_name_contents)->where('cont_id', '!=', NULL);
        $query->and_where('cont_main', '=', 1);
        $query->and_where('cont_show', '=', 1);
        $query->order_by('cont_order')->order_by('cont_id', 'DESC');
        $docs = $query->execute()->as_array();
        $all_categories = $this->get_categories();
        return $this->get_total_contents($docs, $all_categories);
    }

    /**
     * Отображение последних документов блога из всех категорий
     * @param null $limit
     * @return array
     */
    public function get_last_contents($limit = NULL) {

        $query = DB::select()->from($this->tbl_name_contents)->where('cont_id', '!=', NULL);
        $query->and_where('cont_show', '=', 1);

        if ($limit != 0) {
            $query->limit($limit);
        }
        $query->order_by('cont_order')->order_by('cont_id', 'DESC');
        $docs = $query->execute()->as_array();
        $all_categories = $this->get_categories();

        return $this->get_total_contents($docs, $all_categories);
    }



}
