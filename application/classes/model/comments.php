<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Comments extends Model {

    /**
     * Название таблицы, которая соотносится с комментариями
     * @var string
     */
    private $table = 'comments';

    /**
     * Вывод клмментариев
     * @param int $id_attitude id отношения к которому добавлен коммент
     * @param string $attitude имя таблицы к которой отностся комменты (напр. page, contents)
     * @return array
     */
    public function get_comments($id_attitude = NULL, $attitude = NULL, $id = NULL) {
        $query = DB::select('*')->from($this->table)->where('id', '!=', NULL);
        if (!empty($attitude)) {
            $query->and_where('attitude', '=', $attitude);
        }
        if (!empty($id_attitude)) {
            $query->and_where('id_attitude', '=', $id_attitude);
        }
        if (!empty($id)) {
            $query->and_where('id', '=', $id);
        }
        if (!Auth::instance()->logged_in('admin')) {
            $query->and_where('show', '=', '1');
        }
        $query->order_by('order', 'ASC')->order_by('id', 'DESC');
        return $query->execute()->as_array();
    }

    public function is_name_exist($name){
        $result = DB::select(array(DB::expr('COUNT(name)'), 'total'))->from($this->table)
        ->where('name', '=', $name)->execute()->get('total');
        return $result;
    }

    public function add_comment($post, $attitude = 'contents') {
        //html::pr($post['id'],1);
        $query = DB::insert($this->table, array(
                    'name',
                    'comment',
                    'show',
                    'order',
                    'id_attitude',
                    'attitude',
                    'date',
                ))->values(array(
            strip_tags(trim($post['name'])),
            strip_tags(trim($post['comment'])),
            empty($post['show']) ? 1 : (int) $post['show'],
            empty($post['order']) ? 0 : (int) $post['order'],
            $post['id'],
            $attitude,
            time()
        ));

        return $query->execute();
    }
    
    public function edit_comment($id, $post) {
        $query = DB::update($this->table)->set(
                        array(
                            'name' => $post['name'],
                            'show' => $post['show'],
                            'comment' => $post['comment'],
                            'order' => $post['order'],                          
                        )
                )->where('id', '=', $id);

        return $query->execute();
    }

    public function delete_comment($id) {
        $query = DB::delete($this->table)->where('id', '=', $id)->limit(1);
        return $query->execute();
    }

}

