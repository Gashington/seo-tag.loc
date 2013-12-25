<?php

defined('SYSPATH') or die('No direct script access.');

class Tree_Lidoccatsorder extends Tree_Lidoccatsimple{
    
    
    
    /**
     * li вложенный список ссылок/категорий
     * @param array $list
     * @param int $id
     * @param string $alias
     * @return string html список дерева меню / категорий
     */
    protected function _li(array $list, $id = 0, $alias = '' ,$n = 0) {
        $li = false;
        $childs = $list;
        $n++;

        foreach ($list as $k => $v) {
            if ($v[$this->parentIdKey] == $id) {
                if (!empty($v[$this->aliasKey])) {
                    $alias_new = $this->_get_alias($alias, $v[$this->aliasKey]);
                } else {
                    $alias_new = NULL;
                }
                unset($childs[$k]);
                $li .= "<li>";                      
                $li .= "<a href='$this->url/index/$alias_new'>" . str_repeat('-', $n) . $v[$this->nameKey] . "</a>";
                $li .= "</li>";
                $sub = $this->_li($childs, $v[$this->idKey], $alias_new, $n);
                if ($sub) {
                    $li .= $sub;
                }
            }
        }
        return $li;
    }
}
