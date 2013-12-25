<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Модель каталога
 */

class Model_Gallery extends Model {

    /**
     * Вывод всех категорий из базы;
     * @param int $id Поиск по id категории
     * @param string $alias Поиск по alias категории
     * @return array  Ассоциативный массив категорий  
     */
    public function get_gcategories($id = NULL, $alias = NULL, $limit = NULL, $offset = NULL) {

        $limit = (int) $limit;
        $offset = (int) $offset;

        $query = DB::select('*')->from('gcategories')->where('gcat_id', '!=', NULL);
        if ($id) {
            $query->and_where('gcat_id', '=', $id);
        }
        if ($alias) {
            $query->and_where('gcat_alias', '=', $alias);
        }


        if ($limit != 0) {
            $query->limit($limit)->offset($offset);
        }

        $query->order_by('gcat_order', 'ASC');

        return $query->execute()->as_array();
    }

    /**
     * Вывод всех галереи;
     * @param int $id Поиск по id категории
     * @param string $alias Поиск по alias категории
     * @return array  Ассоциативный массив категорий  
     */
    public function get_gallery($id = NULL, $cat_ids = array()) {
        $query = DB::select('*')->from('gallery')->where('g_id', '!=', NULL);
        if ($id) {
            $query->and_where('g_id', '=', $id);
        }
        if (!empty($cat_ids))
            $query->and_where('g_cat_id', 'IN', $cat_ids);
        //$query->order_by('gcat_order', 'ASC');
        return $query->execute()->as_array();
    }

    public function add_gallery($post, $img) {
        $query = DB::insert('gallery', array(
                    //'g_name',
                    'g_cat_id',
                    //'g_title',
                    //'g_meta_k',
                    //'g_meta_d',
                    'g_body',
                    'g_img',
                ))->values(array(
            //$post['name'],  
            $post['cat_id'],
            //empty($post['title']) ? $post['name'] : $post['title'],
            //$post['meta_k'],
            //$post['meta_d'],        
            $post['body'],
            empty($img) ? '' : $img,
        ));

        return $query->execute();
    }

    public function update_gallery($post, $img, $id) {

        $arr = array(
            //'g_name' => $post['name'],
            'g_cat_id' => $post['cat_id'],
            //'g_title' => $post['title'],
            //'g_meta_k' => $post['meta_k'],
            //'g_meta_d' => $post['meta_d'],
            'g_body' => $post['body'],
            'g_img' => $img,
        );

        $query = DB::update('gallery')->set($arr)->where('g_id', '=', $id);

        return $query->execute();
    }

    /*
     * Удаление галерею по id и все рисунки в ней
     */

    public function delete_gallery($id) {
        $dir_upload = Kohana::$config->load('conf.dir_upload_gallery');
        $q = DB::select('g_img')->from('gallery')->where('g_id', '=', $id)->execute()->as_array();
        $imgs = empty($imgs) ? array() : explode('|', $q[0]['pr_img']);

        foreach ($imgs as $img) {
            if (file_exists($dir_upload . '/' . $img)) {
                unlink($dir_upload . '/' . $img);
                unlink($dir_upload . '/small_' . $img);
            }
        }

        $query = DB::delete('gallery')->where('g_id', '=', $id)->limit(1);
        return $query->execute();
    }

    /**
     * Редактировать категорию
     */
    public function update_gcategory($post, $img, $id) {
        $arr = array(
            'gcat_name' => $post['name'],
            'gcat_alias' => $post['alias'],
            'gcat_title' => $post['title'],
            'gcat_meta_k' => $post['meta_k'],
            'gcat_meta_d' => $post['meta_d'],
            'gcat_show' => $post['show'],
            'gcat_order' => $post['order'],
            'gcat_text' => $post['text'],
            'gcat_img' => $img,
        );
        if (empty($img)) {
            unset($arr['gcat_img']);
        }
        $query = DB::update('gcategories')->set($arr)->where('gcat_id', '=', $id);

        return $query->execute();
    }

    public function add_gcategory($post, $img) {
        $query = DB::insert('gcategories', array(
                    'gcat_name',
                    'gcat_alias',
                    'gcat_title',
                    'gcat_meta_k',
                    'gcat_meta_d',
                    'gcat_show',
                    'gcat_order',
                    'gcat_text',
                    'gcat_img',
                ))->values(array(
            $post['name'],
            $post['alias'],
            empty($post['title']) ? $post['name'] : $post['title'],
            $post['meta_k'],
            $post['meta_d'],
            $post['show'],
            $post['order'],
            $post['text'],
            $img
        ));

        return $query->execute();
    }

    /*
     * Удалить категорию
     */

    public function delete_cat($id) {

        // проверяем есть ли связанные статьи
        $query = DB::select('g_cat_id')
                ->from('gallery')
                ->where('g_cat_id', '=', $id);

        $result = $query->execute()->count();

        if ($result > 0) {
            return 2;
        }

        $query = DB::select()->from('gcategories')->where('gcat_id', '=', $id)->limit(1);
        $result = $query->execute()->as_array();
        $dir_upload = Kohana::$config->load('conf.dir_upload_gallery') . '/categories';
        $img = empty($result[0]['gcat_img']) ? NULL : $result[0]['gcat_img'];
        if (is_file($dir_upload . '/' . $img)) {
            unlink($dir_upload . '/' . $img);
            unlink($dir_upload . '/small_' . $img);
        }

        $query = DB::delete('gcategories')->where('gcat_id', '=', $id)->limit(1);
        return $query->execute();
    }

    public function unique_alias($alias, $id = null) {

        $result = DB::select(array(DB::expr('COUNT(gcat_alias)'), 'total'))
                ->from('gcategories')
                ->where('gcat_alias', '=', $alias)
                ->and_where('gcat_id', '!=', $id)
                ->execute()
                ->get('total');

        if ($result == 0)
            return true;
        else
            return false;
    }

    /**
     * AJAX сортировка категорий галереи (перетаскиванием)
     * @param int $id
     * @param string $order
     * @return type
     */
    public function sortcats($id, $order) {
        $query = DB::update('gcategories')->set(array('gcat_order' => $order))->where('gcat_id', '=', $id);
        return $query->execute();
    }

    /**
     * AJAX сортировка изображений галереи (перетаскиванием)
     * @param int $id
     * @param string $order
     * @return type
     */
    public function sortimg($id, $sortimg) {

        if (!empty($sortimg)) {
            $sortimg = implode('|', $sortimg);

            $query = DB::update('gallery')->set(array('g_img' => $sortimg))->where('g_id', '=', $id);
            return $query->execute();
        }
    }

    /**
     * изменение поля pr_img в базе на предмет количества изображений
     * если например из вормы удаляются некоторые изображения
     * $imgs = array() массив изображений извне
     */
    public function edit_gallery_imgs($imgs, $id) {
        $dir_upload = Kohana::$config->load('conf.dir_upload_gallery');
        $galleries = $this->get_gallery($id);
        $galleries_imgs = explode('|', $galleries[0]['g_img']);

        foreach ($galleries_imgs as $k => $g_img) {
            if (in_array($g_img, $imgs)) {
                unset($galleries_imgs[$k]);
                if (file_exists($dir_upload . '/' . $g_img)) {
                    unlink($dir_upload . '/' . $g_img);
                    unlink($dir_upload . '/small_' . $g_img);
                }
            }
        }
        $img = implode('|', $galleries_imgs);

        $query = DB::update('gallery')->set(
                        array(
                            'g_img' => $img
                        )
                )->where('g_id', '=', $id)->execute();

        return true;
    }

}