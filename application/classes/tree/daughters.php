<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Дочерние категории
 */
class Tree_Daughters implements Tree_Tree {

    /**
     * Названия ключа массива с родительским id
     * @var string 
     */
    protected $parentIdKey = NULL;

    /**
     * Названия ключа массива с id
     * @var string 
     */
     protected  $idKey = NULL; 
    
    /**
     * Массив категорий
     * @var array() 
     */
     protected  $list = array();
    
    

   /**
     * Рекурсивный метод вывода дочерних категорий;
     * @param array $list Массив всех категорий
     * @param int $id id родительской категории 
     * @return array Массив дочерних категорий
     */
   protected function _get_relates($list, $id = 0) {
        $id = empty($id) ? 0 : $id;
        $menu = false;
        $childs = $list;
        foreach ($list as $k => $v)
            if ($v[$this->parentIdKey] == $id) {
                unset($childs[$k]);
                $menu[] = $list[$k];
                $sub = $this->_get_relates($childs, $v[$this->idKey]);
                if ($sub) {
                    $menu = array_merge($menu, $sub);
                }
            }
        return empty($menu) ? array() : $menu;
    }
    
    /**
     * Устанавливает ключи
     * @param string $IdKey
     * @param string $ParentIdKey
     * @throws Exception
     */
    public function setKeys($idKey = NULL, $parentIdKey = NULL){    
        if (empty($idKey)) {
            throw new Exception ('Название ключа idKey не может быть пустым');
        }
        else{
            $this->idKey = $idKey;
        }
        if (empty($parentIdKey)) {
           throw new Exception ('Название ключа parentIdKey не может быть пустым');
        }
        else{
            $this->parentIdKey = $parentIdKey;
        }      
    }
    
    /**
     * Устанавливает параметры
     * @param array $list
     * @param int  $id
     */
    public function setParams(array $list, $id = 0){
        $this->list = $list;
        $this->id = (int)$id;      
    }

    public function show() {
        if($this->idKey == NULL || $this->parentIdKey == NULL){
            throw new Exception ('Не заданы имена ключей');
        }
        return $this->_get_relates($this->list, $this->id);
    }

}

