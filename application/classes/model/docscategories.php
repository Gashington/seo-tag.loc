<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Docscategories extends Model_Docs {

    /**
     * Название таблицы категорий
     * @var type string
     */
    private $tbl_name_cats = 'categories';
    /**
     * Название таблицы контента
     * @var type string
     */
    private $tbl_name_contents = 'contents';

    /**
     * Вывод всех категорий документов из базы;
     * @param int $id Поиск по id категории
     * @param string $alias Поиск по alias категории
     * @return array  Ассоциативный массив категорий
     */
    public function get_categories($id = NULL, $alias = NULL) {

        $query = DB::select('*')->from($this->tbl_name_cats)->where('cat_id', '!=', NULL);

        if (!empty($id)) {
            $query->and_where('cat_id', '=', $id);
        }

        if (!empty($alias)) {
            $query->and_where('cat_alias', '=', $alias);
        }

        $query->order_by('cat_order', 'ASC')->order_by('cat_id', 'ASC');

        return $query->execute()->as_array();
    }
    
    /**
     * Массив всех категорий
     * @param type $obj
     * @return array
     */
    public function get_all_cats($obj) {
        if (!$all_categories = $obj->cache->get('cache_all_categories')) {
            $all_categories = $this->get_categories();
            $obj->cache->set('cache_all_categories', $all_categories);
        }
        return $all_categories;
    }

    public function get_cat_active($alias_last) {
        if (empty($alias_last)) {
            return NULL;
        } else {
            $cat_active = $this->get_categories(NULL, $alias_last);
            return empty($cat_active[0]) ? NULL : $cat_active[0];
        }
    }  

    public function get_cats_daughter_id(array $all_cats, $active_catid) {
        $arr_cats_id = array();
        $cats_daughter = $this->get_daughter($all_cats, $active_catid);
        foreach ($cats_daughter as $v) {
            $arr_cats_id[] = $v['cat_id'];
        }
        // добавляем текущую категорию в массив
        $arr_cats_id[] = $active_catid;
        return empty($arr_cats_id) ? array() : $arr_cats_id;
    }

    

    /**
     * Добавление категории
     * @param obj $post
     * @return type
     */
    public function add_cat($post, $img) {

        $query = DB::insert($this->tbl_name_cats, array(
                    'cat_name',
                    'cat_title',
                    'cat_meta_k',
                    'cat_meta_d',
                    'cat_img',
                    'cat_view',
                    'cat_class',
                    'cat_alias',
                    'cat_show',
                    'cat_text',
                    'cat_parent_id'
                ))->values(array(
            $post['name'],
            $post['title'],
            $post['meta_k'],
            $post['meta_d'],
            $img,
            $post['view'],
            $post['class'],
            $post['alias'],
            $post['show'],
            $post['text'],
            $post['cats'],
        ));
        return $query->execute();
    }

    public function edit_cat($id, $post, $img) {
        
        $arr = array(
            'cat_name' => $post['name'],
            'cat_title' => $post['title'],
            'cat_meta_k' => $post['meta_k'],
            'cat_meta_d' => $post['meta_d'],
            'cat_img' => $img,
            'cat_view' => $post['view'],
            'cat_show' => $post['show'],
            'cat_class' => $post['class'],
            'cat_alias' => $post['alias'],
            'cat_text' => $post['text'],
            'cat_parent_id' => $post['cats'],
        );
        // если родитель равен id итема, не обновлеме поле родителя
        if ($post['cats'] == $id){
            unset($arr['cat_parent_id']);
        }
       
        $query = DB::update($this->tbl_name_cats)->set($arr)->where('cat_id', '=', $id);
        return $query->execute();
        
    }

    /**
     * Удаление категории
     * @param int $id
     * @return int
     */
    public function delete_cat($id) {

        $dir_upload = Kohana::$config->load('conf.dir_upload_preview');
        // проверяем , есть ли потомки у категории
        $query = DB::select('cat_parent_id')
                ->from($this->tbl_name_cats)
                ->where('cat_parent_id', '=', $id);
        $result = $query->execute()->count();
        if ($result > 0) {
            return 2;
        }
        // проверяем есть ли связанные статьи
        $query = DB::select('cont_cat_id')
                ->from($this->tbl_name_contents)
                ->where('cont_cat_id', '=', $id);
        $result = $query->execute()->count();
        if ($result > 0) {
            return 3;
        }

        $result = $this->get_categories($id);
        $img = empty($result[0]['cat_img']) ? NULL : $result[0]['cat_img'];
        // удаляем картинки из превью      
        $this->unlink_preview($dir_upload , $img); 
        // удаляем картики из контента!
        //html::del_imgs_from_content($result[0]['cont_tiser']);
        //html::del_imgs_from_content($result[0]['cont_body']);

        $query = DB::delete($this->tbl_name_cats)->where('cat_id', '=', $id)->limit(1);
        return $query->execute();
    }
    
    /**
     * Удаление превью
     * @param int $id
     * @return void
     */
    public function delpreview_category($id){  
        $query = DB::update($this->tbl_name_cats)->set(
                        array('cat_img' => '')
                )->where('cat_id', '=', $id);

        return $query->execute();
    }

    /**
     * Проверка алиаса на уникальность
     */
    public function unique_addalias($alias) {

        $result = DB::select(array(DB::expr('COUNT(cat_alias)'), 'total'))
                ->from($this->tbl_name_cats)
                ->where('cat_alias', '=', $alias)
                ->execute()
                ->get('total');
        if ($result == 0)
            return true;
        else
            return false;
    }

    public function unique_alias($alias, $id = null) {

        $result = DB::select(array(DB::expr('COUNT(cat_alias)'), 'total'))
                ->from($this->tbl_name_cats)
                ->where('cat_alias', '=', $alias)
                ->and_where('cat_id', '!=', $id)
                ->execute()
                ->get('total');

        if ($result == 0)
            return true;
        else
            return false;
    }
    
    /**
     * Валидация post данных
     * @return object
     */
    protected function post_validation() {
        $post = Validation::factory($_POST);
        $post->rule('name', 'not_empty')
                ->rule('cats', 'digit')
                ->labels(array(
                    'name' => 'Название',
                    'cats' => 'Категории',
        ));
        return $post;
    }
    
    /**
     * Валидация изображений
     * @param array $_FILES
     * @return object
     */
    protected function img_validation() {
        $valid_types = array('jpg', 'png', 'gif', 'jpeg');
        $validation = Validation::factory($_FILES)
                //->rule('images', 'Upload::not_empty')
                ->rule('images', 'Upload::type', array(':value', $valid_types))
                ->rule('images', 'Upload::size', array(':value', '5M'))
                ->labels(array(
            'images' => 'Файл'
        ));
        return $validation;
    }

}
