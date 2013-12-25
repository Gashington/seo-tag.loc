<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Родительские категории, основной функционал берем из Tree_Daughters
 */
class Tree_Parents extends Tree_Daughters {
 
   /**
     * Рекурсивный метод вывода родительских категорий;
     * @param array $list Массив всех категорий
     * @param int $id id родительской категории 
     * @return array Массив родительских категорий
     */
   protected function _get_relates($list, $id = 0) {
        $id = empty($id) ? 0 : $id;
        $menu = false;
        $childs = $list;
        foreach ($list as $k => $v)
            if ($v[$this->idKey] == $id) {
                unset($childs[$k]);
                $menu[] = $list[$k];
                $sub = $this->_get_relates($childs, $v[$this->parentIdKey]);
                if ($sub) {
                    $menu = array_merge($menu, $sub);
                }
            }
        return empty($menu) ? array() : $menu;
    }

}

