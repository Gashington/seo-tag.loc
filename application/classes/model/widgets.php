<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Widgets extends Model {

    /**
     * Вывести все виджеты
     * @param string $alias
     * @param array $orderby параметры сортировки
     * @return type
     */
    public function get_widgets($alias = null, $orderby = array('id', 'ASC')) {
        $query = DB::select()->from('widgets');
        if ($alias) {
            $query->where('alias', 'like', "html%");
        }
        if (!empty($orderby)) {
            $query->order_by($orderby[0], $orderby[1]);
        }
        return $query->execute()->as_array();
    }

    /**
     * Получение виджета
     * @param int $id
     * @param string $alias
     * @return string
     */
    public function get_one_widget($id = null, $alias = null) {
        $query = DB::select()->from('widgets');
        if ($id) {
            $query->where('id', '=', $id);
        }
        if ($alias) {
            $query->where('alias', '=', $alias);
        }
        // не выводить выключенный виджет, кроме режима админа
        if (!Auth::instance()->logged_in('admin')) {
            $query->and_where('show', '=', '1');
        }
        $result = $query->execute()->as_array();

        return empty($result[0]) ? '' : $result[0];
    }

    /**
     * Редактировать виджет
     * @param int $id
     * @param string $name
     * @param string $alias
     * @param string $config
     * @param int $show
     * @param string $content
     * @return type
     */
    public function update_widgets($id, $post) {

        $query = DB::update('widgets')->set(
                        array(
                            'name' => trim($post['name']),
                            'alias' => trim($post['alias']),
                            'config' => trim($post['config']),
                            'content' => empty($post['content']) ? '' : trim($post['content']),
                            'show' => trim($post['show'])
                        )
                )->where('id', '=', (int) $id);

        return $query->execute();
    }

    /**
     * Добавить виджет
     * @param obj $post
     * @param int $id
     * @return type
     */
    public function add_widgets($post, $id = null) {

        if ($id) {
            $query = DB::insert('widgets', array('name', 'alias', 'config', 'show', 'content', 'id'))
                    ->values(array(
                trim($post['name']),
                trim($post['alias']),
                trim($post['config']),
                trim($post['show']),
                trim($post['content']),
                (int) $id
            ));
        } else {
           
            $query = DB::insert('widgets', array('name', 'alias', 'config', 'show', 'content'))
                    ->values(array(
                trim($post['name']),
                trim($post['alias']),
                trim($post['config']),
                trim($post['show']),
                ''
            ));
        }

        return $query->execute();
    }

    /**
     * Удалить виджет
     * @param int $id
     * @return type
     */
    public function delete_widgets($id) {
        $query = DB::delete('widgets')->where('id', '=', $id)->limit(1);
        return $query->execute();
    }

    /**
     * Проверить alias на уникальность
     * @param string $alias
     * @param int $id
     * @return boolean
     */
    public function unique_alias($alias, $id = null) {

        $result = DB::select(array(DB::expr('COUNT(alias)'), 'total'))
                ->from('widgets')
                ->where('alias', '=', $alias)
                ->and_where('id', '!=', $id)
                ->execute()
                ->get('total');

        if ($result == 0)
            return true;
        else
            return false;
    }

}

