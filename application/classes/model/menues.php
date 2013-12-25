<?php

defined('SYSPATH') or die('No direct script access.');

/*
 * Модель меню
 */

class Model_Menues extends Model {
    
    /**
     * Название таблицы меню
     */
    protected $menu = 'menues';

    /**
     * Название таблицы типов меню
     */
    protected $memues_type = 'menues_type';

    public function get_menu_types($alias = null, $id = null) {
        $query = DB::select()->from($this->memues_type)->where('menut_id', '!=', NULL);
        if ($alias) {
            $query->and_where('menut_alias', '=', $alias);
        }
        if ($id) {
            $query->and_where('menut_id', '=', $id);
        }
        $query->order_by('menut_order', 'ASC')->order_by('menut_id', 'ASC');
        return $query->execute()->as_array();
    }
    
    /**
     * Вывод меню
     * @param string $controller
     * @param int $id id меню
     * @param string $type тип меню, например - main(главное)
     * @return array
     */
    public function get_menu($controller = null, $id = null, $type = null, $type_id = null) {

        $query = DB::select()
                        ->from($this->menu)
                        ->join($this->memues_type)->on('menu_menut_id', '=', 'menut_id');


        $query->where('menu_id', '!=', NULL);

        if (!Auth::instance()->logged_in('admin')) {
            $query->and_where('menu_show', '=', 1);
        }

        if ($type) {
            $query->and_where('menut_alias', '=', $type);
        }

        if ($type_id) {
            $query->and_where('menu_menut_id', '=', $type_id);
        }

        // если есть параметр $controller, ищем url в составе которого этот контроллер
        if ($controller) {
            $query->and_where('menu_url', 'like', '%' . $controller . '%');
        }

        if ($id) {
            $query->and_where('menu_id', '=', $id);
        }

        $query->order_by('menu_order', 'ASC')->order_by('menu_id', 'ASC');

        return $query->execute()->as_array();
    }
    
    public function get_li_menu_front($list, $id = 0) {
        $litree = Factory::set('Tree_Limenufront');
        $litree ->setParams($list, $id);
        $litree ->setKeys('menu_id','menu_parant_id','menu_name', 'menu_url', 'menu_match', 'menu_item_class');
        return $litree->show(); 
    }
    
    public function get_map($list, $id = 0) {
        $litree = Factory::set('Tree_Map');
        $litree ->setParams($list, $id);
        $litree ->setKeys('menu_id','menu_parant_id','menu_name', 'menu_url', 'menu_match', 'menu_item_class');
        return $litree->show(); 
    }
    
    public function get_li_menu_admin($list, $id = 0) {
        $litree = Factory::set('Tree_Limenuadmin');
        $litree ->setParams($list, 0);
        $litree ->setKeys('menu_id','menu_parant_id','menu_name');
        return $litree->show();
    }
    
    public function get_option_menu($list, $id = 0, $c = 0, $selectedid = NULL) {
        $optionstree = Factory::set('Tree_Optionstree');
        $optionstree ->setKeys('menu_id','menu_parant_id','menu_name');
        $optionstree ->setParams($list, $id, $c, $selectedid);
        return $optionstree->show();
    }
    
    public function add_menu($post) {
        $arr = array(
            $post['name'],
            $post['url'],
            empty($post['match']) ? $post['url'] : $post['match'],
            empty($post['title']) ? $post['name'] : $post['title'],
            $post['show'],
            $post['order'],
            $post['class'],
            $post['parant_id'],
            $post['menut_id'],
        );

        $query = DB::insert($this->menu, array(
                    'menu_name',
                    'menu_url',
                    'menu_match',
                    'menu_title',
                    'menu_show',
                    'menu_order',
                    'menu_item_class',
                    'menu_parant_id',
                    'menu_menut_id',
                ))->values($arr);

        return $query->execute();
    }
    
    public function update_menus($post, $parant_id, $menu_id) {

        $arr = array(
            'menu_name' => $post['name'],
            'menu_title' => $post['title'],
            'menu_url' => $post['url'],
            'menu_menut_id' => $post['menut_id'],
            'menu_match' => $post['match'],
            'menu_show' => $post['show'],
            'menu_order' => $post['order'],
            'menu_item_class' => $post['class'],
            'menu_parant_id' => $parant_id,
        );
        $query = DB::update($this->menu)->set($arr)->where('menu_id', '=', $menu_id);

        // если родитель равен id итема, не обновлеме поле родителя
        if ($parant_id == $menu_id) {
            unset($arr['menu_parant_id']);
        }

        return $query->execute();
    }
    
    public function add_menutype($post) {
        $arr = array(
            $post['name'],
            empty($post['h']) ? $post['name'] : $post['h'],
            $post['show'],
            $post['alias'],
            $post['order'],
            $post['descr'],
        );

        $query = DB::insert($this->memues_type, array(
                    'menut_name',
                    'menut_h',
                    'menut_show',
                    'menut_alias',
                    'menut_order',
                    'menut_descr',
                ))->values($arr);

        return $query->execute();
    }

    /*
     * Удалить пункт меню
     */

    public function delete_menu($id) {

        // проверяем , есть ли потомки у пункта меню
        $query = DB::select('menu_parant_id')
                ->from($this->menu)
                ->where('menu_parant_id', '=', $id);

        $result = $query->execute()->count();

        if ($result > 0) {
            return 2;
        }

        $query = DB::delete($this->menu)->where('menu_id', '=', $id)->limit(1);
        return $query->execute();
    }

    /*
     * Удалить тип меню со всеми пуктами (движок innoDB)
     */

    public function del_type($id) {
        $query = DB::delete($this->memues_type)->where('menut_id', '=', $id)->limit(1);
        return $query->execute();
    }

    public function unique_alias($alias, $id = null) {

        $result = DB::select(array(DB::expr('COUNT(menut_alias)'), 'total'))
                ->from($this->memues_type)
                ->where('menut_alias', 'like', '%' . $alias . '%')
                ->and_where('menut_id', '!=', $id)
                ->execute()
                ->get('total');

        if ($result == 0){
            return true;
        }
        else{
            return false;
        }
    }


}
