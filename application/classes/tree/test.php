<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Вывод дерева списков категорий option
 */
class Tree_Test implements Tree_Tree {

    /**
     * Названия ключа массива с родительским id
     * @var string 
     */
    private $parentIdKey = NULL;

    /**
     * Названия ключа массива с id
     * @var string 
     */
    private $idKey = NULL;

    /**
     * Название ключа имени ссылки
     * @var string 
     */
    private $nameKey = NULL;
    
    /**
     * Массив категорий
     * @var array() 
     */
    private $list = array();
    
    /**
     * Счетчик отступов
     * @var int
     */
    private $n = 0;
    
    /**
     * Указатель на текущий id
     * @var int
     */
    private $selectedid = NULL;

    /**
     * Формирует option - cписок категорий без тега select
     * @param array $list
     * @param int $id
     * @param int $n счетчик отступов
     * @param int $selectedid текущий id пункта
     * @return string Option cписок категорий
     */
    protected function _arr(array $list, $id = 0) {
        static $deep = 1; 
       
        $menu = false;
        $childs = $list;
        foreach ($list as $k => $v){
            if ($v[$this->parentIdKey] == $id) {
                
                unset($childs[$k]);               
                $menu[$k] = $list[$k];
               
                $sub = $this->_arr($childs, $v[$this->idKey]);
                if ($sub) {
                    $menu[$k]['sub'] = $sub;
                    //$menu = array_merge($menu, $sub);
                }              
            }
            
        }
        
        $m = $menu;
        return empty($menu) ? array() : $m;
    }
    
    /**
     * Устанавливает ключи
     * @param string $IdKey
     * @param string $ParentIdKey
     * @param string $NameKey
     * @throws Exception
     */
    public function setKeys($idKey = NULL, $parentIdKey = NULL, $nameKey = NULL, $aliasKey = NULL) {
        if (empty($idKey)) {
            throw new Exception('Название ключа idKey не может быть пустым');
        } else {
            $this->idKey = $idKey;
        }

        if (empty($parentIdKey)) {
            throw new Exception('Название ключа parentIdKey не может быть пустым');
        } else {
            $this->parentIdKey = $parentIdKey;
        }

        if (empty($nameKey)) {
            throw new Exception('Название ключа nameKey не может быть пустым');
        } else {
            $this->nameKey = $nameKey;
        }

        if (empty($aliasKey)) {
            throw new Exception('Название ключа aliasKey не может быть пустым');
        } else {
            $this->aliasKey = $aliasKey;
        }
    }

    /**
     * Устанавливает параметры
     * @param array $list
     * @param string  $url
     * @param int $id
     */
    public function setParams(array $list, $url = '', $id = 0) {
        $this->list = $list;
        $this->url = $url;
        $this->id = (int) $id;
    }

    public function show() {
        if ($this->idKey == NULL || $this->parentIdKey == NULL || $this->nameKey == NULL || $this->aliasKey == NULL) {
            throw new Exception('Не задано именя ключа');
        }
        return $this->_arr($this->list, $this->id);
    }

    /**
     * css класс current для текущих пунктов
     * @param string $alias_new
     * @return string
     */
    protected function _setActiveClass($match) {
        if (empty($match)) {
            return '';
        }
        $activ_url = trim($_SERVER['REQUEST_URI'], '/');
        return strpos($activ_url, $match) !== FALSE || ($match == 'main' && $_SERVER['REQUEST_URI'] == '/') ? $this->liClassActive : '';
    }

    /**
     * Расстановка / у alias
     * @param string $alias Текущий alias
     * @param string $alias_new Следующий в группе алиас (добавляется через /)
     * @return string Цепочка alias
     */
    protected function _get_alias($alias, $alias_new) {
        $alias = (self::$alias_count == 0 && !empty($alias)) ? '/' . $alias : $alias;
        self::$alias_count++;
        $alias_new = $alias . '/' . $alias_new;
        return trim($alias_new, '/');
    }


}
