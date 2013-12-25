<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Slider extends Model {

    /**
     * Имя таблицы
     * @var string
     */
    private $name_table = 'slider';

    public function get_slides($id = NULL) {
        $query = DB::select()->from($this->name_table)->where('id', '!=', NULL);;

        if (!empty($id)) {
            $query->and_where('id', '=', $id);
        }
        
        if (!Auth::instance()->logged_in('admin')) {
            $query->and_where('show', '=', '1');
        }

        $query->order_by('order', 'ASC')->order_by('id', 'ASC');

        return $query->execute()->as_array();
    }

    public function add_slide($post, $img_main, $img_add) {

        $params = json_encode(array(
            'top' => empty($post['top']) ? 0 : (int) $post['top'],
            'left' => empty($post['left']) ? 0 : (int) $post['left'],
        ));

        $arr = array(
            $img_main,
            $post['title'],
            $post['desc'],
            $img_add,
            $post['link'],
            $params,
            (int)$post['order'],
            (int)$post['show']
        );

        $query = DB::insert($this->name_table, array(
                    'img_main',
                    'title',
                    'desc',
                    'img_add',
                    'link',
                    'params',
                    'order',
                    'show'
                ))->values($arr);

        return $query->execute();
    }

    public function edit_slide($id, $post, $img_main, $img_add) {
        //html::pr($post, 1);
        
        $params = json_encode(array(
            'top' => empty($post['top']) ? 0 : (int) $post['top'],
            'left' => empty($post['left']) ? 0 : (int) $post['left'],
        ));

        $query = DB::update($this->name_table)->set(
                        array(
                            'img_main' => $img_main,
                            'title' => $post['title'],
                            'desc' => $post['desc'],
                            'img_add' => $img_add,
                            'link' => $post['link'],
                            'params' => $params,
                            'order' => (int)$post['order'],
                            'show' => (int)$post['show'],
                        )
                )->where('id', '=', $id);

        return $query->execute();
    }

    public function delete_slide($id) {

        $dir = Kohana::$config->load('conf.dir_upload_slider');

        $result = $this->get_slides($id);

        $img_main = empty($result[0]['img_main']) ? '' : $result[0]['img_main'];
        $img_add = empty($result[0]['img_add']) ? '' : $result[0]['img_add'];

        // удаляем картинки
        if (is_file($dir . '/' . $img_main)) {
            unlink($dir . '/' . $img_main);
            unlink($dir . '/small_' . $img_main);
        }
        if (is_file($dir . '/back/' . $img_add)) {
            unlink($dir . '/back/' . $img_add);
            unlink($dir . '/back/small_' . $img_add);
        }

        $query = DB::delete($this->name_table)->where('id', '=', $id)->limit(1);
        return $query->execute();
    }
    
    /**
     * Сортировка материалов
     * @param array $cont_ids
     * @param array $cont_orders
     * @return boolean
     */
    public function edit_slider_order($slider_ids, $slider_orders) {
        foreach ($slider_ids as $k => $v) {
            $query = DB::update($this->name_table)->set(array('order' => $slider_orders[$k]))->where('id', '=', $v)->execute();
        }
        return true;
    }

}
