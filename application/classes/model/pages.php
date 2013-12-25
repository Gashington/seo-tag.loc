<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Pages extends Model {
    /**
     * Название таблицы
     * @var string
     */
    private $tbl_name = 'pages';

    public function get_one_page($alias, $id = NULL) {

        $query = DB::select()->from($this->tbl_name);
        if ($id == NULL){
            $query->where('alias', '=', $alias);
        }
        else{
            $query->where('id', '=', $id);
        }
        if (!Auth::instance()->logged_in('admin')) {
            $query->and_where('show', '=', '1');
        }
        $query->limit(1);
        $result = $query->execute()->as_array();
        return empty($result[0]) ? array() : $result[0];
    }

    
    public function get_pages() {
        $query = DB::select()->from($this->tbl_name);
        return $query->execute()->as_array();
    }

  
    public function add_page($post, $img) {
        $arr = array(
            $post['name'],
            empty($post['title']) ? $post['name'] : $post['title'],
            $post['meta_k'],
            $post['meta_d'],
            $post['alias'],
            $post['content'],
            (int) $post['show'],
            $img,
        );
        $query = DB::insert($this->tbl_name, array(
            'name', 
            'title', 
            'meta_k', 
            'meta_d', 
            'alias', 
            'content', 
            'show', 
            'img'))
                ->values($arr);

        return $query->execute();
    }

   

    public function edit_page($post, $params, $img) {

        $query = DB::update($this->tbl_name)->set(
                        array(
                            'name' => $post['name'],
                            'title' => $post['title'],
                            'meta_k' => $post['meta_k'],
                            'meta_d' => $post['meta_d'],
                            'alias' => $post['alias'],
                            'show' => $post['show'],
                            'content' => $post['content'],
                            'img' => $img
                        )
                )->where('id', '=', $params);

        return $query->execute();
    }

    /*
     * Удалить страницу
     */

    public function delete_page($id) {
        $query = DB::delete($this->tbl_name)->where('id', '=', $id)->limit(1);
        return $query->execute();
    }
    
    /**
     * Удаление превью
     * @param int $id
     * @return void
     */
    public function delpreview_page($id){  
        $query = DB::update($this->tbl_name)->set(
                        array('img' => '')
                )->where('id', '=', $id);

        return $query->execute();
    }

    /*
     * Проверить alias на уникальность
     */

    public function unique_alias($alias, $id = null) {
        $result = DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                ->from($this->tbl_name)
                ->where('alias', '=', $alias)
                ->and_where('id', '!=', $id)
                ->execute()
                ->get('total');

        if ($result == 0)
            return true;
        else
            return false;
    }
    
    /**
     * 
     * @param string $dir путь до папки
     * @param string $img название картинки
     * @return int
     */
    public function unlink_preview($dir, $img){
        if (is_file($dir . '/' . $img)) {
            if(!unlink($dir . '/' . $img)){
                throw new Exception ('Не могу удалить ' .$img); 
            }
        }
        if(is_file($dir . '/small_' . $img)){
            if(!unlink($dir . '/small_' . $img)){
                throw new Exception ('Не могу удалить ' . '/small_'.$img); 
            };
        }
        return 1;
    }

}

