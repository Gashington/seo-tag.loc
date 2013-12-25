<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Вывод дерева категорий блога для админки, основной функционал из Lidoccatsimple
 */
class Tree_Tabledoccatadmin extends Tree_Lidoccatsimple{
    
    private $urlEdit = 'edit';
    private $urlDel = 'delete';   
    private $urlEditName = '<i class="icon-edit"></i>';
    private $urlDelName = '<i class="icon-remove"></i>';

     /**
     * Table вложенный список ссылок/категорий
     * @param array $list
     * @param int $id
     * @return string html список дерева меню / категорий
     */
    protected function _table(array $list, $id = 0, $n = 0) {
        $n++;
        $id = empty($id) ? 0 : (int) $id;
        $menu = false;
        $childs = $list;
        foreach ($list as $k => $v) {
            //html::pr($v,1);
            if ($v[$this->parentIdKey] == $id) {                           
                unset($childs[$k]);                                            
                $menu .= "<tr>";              
                $menu .= "<td>";
                $menu .= $v[$this->idKey];
                $menu .= "</td>";
                $menu .= "<td>";
                $menu .= str_repeat('-', $n) . $v[$this->nameKey];
                $menu .= "</td>";               
                $menu .= "<td>";
                $menu .= " <a href='$this->url/$this->urlEdit/{$v[$this->idKey]}'>$this->urlEditName</a>";
                $menu .= "</td>";
                $menu .= "<td>";
                $menu .= " <a href='$this->url/$this->urlDel/{$v[$this->idKey]}'>$this->urlDelName</a>";
                $menu .= "</td>";
                $sub = $this->_table($childs, $v[$this->idKey], $n);

                if ($sub) {
                    $menu .= $sub;
                }
                $menu .= "</tr>";
            }
        }
        return $menu;
    }
    
    public function show() {
        if ($this->idKey == NULL || $this->parentIdKey == NULL || $this->nameKey == NULL || $this->aliasKey == NULL) {
            throw new Exception('Не задано именя ключа');
        }
        return $this->_table($this->list, $this->id);
    }
     
}
