<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Вывод дерева списков категорий option
 */
class Tree_Limenufront implements Tree_Tree {

    /**
     * Названия ключа массива с родительским id
     * @var string 
     */
    protected $parentIdKey = NULL;

    /**
     * Названия ключа массива с id
     * @var string 
     */
    protected $idKey = NULL;

    /**
     * Название ключа имени ссылки
     * @var string 
     */
    protected $nameKey = NULL;
    
    protected $urlKey = NULL;
    
    protected $matchKey = NULL;
    
    protected $itemClassKey = NULL;

    /**
     * Массив категорий
     * @var array() 
     */
    protected $list = array();
      
    protected $ulClassDeep = 'dropdown-menu parent';  
    protected $ulClassParent = 'nav';
    protected $liClassActive = ' active';
    

    /**
     * li вложенный список ссылок/категорий
     * @param array $list
     * @param int $id
     * @param string $alias
     * @return string html список дерева меню / категорий
     */
    protected function _li(array $list, $id = 0) {
        $n = 0;
        $id = empty($id) ? 0 : (int) $id;
        $menu = false;
        $childs = $list;
        foreach ($list as $k => $v) {
            //html::pr($v,1);
            if ($v[$this->parentIdKey] == $id) {

                if (!$menu) {
                    $menu = $id ? "<ul class='$this->ulClassDeep'>" : "<ul class='$this->ulClassParent'>";
                }
                unset($childs[$k]);
                
                $active_class = $this->_setActiveClass($v[$this->matchKey]);          
                $item_class = empty($v[$this->itemClassKey]) ? '' : ' ' . $v[$this->itemClassKey];
                
                $menu .= "<li class='item$n$active_class$item_class'>";                         
                $n++;
                $menu .= "<a href='/{$v[$this->urlKey]}'>" . $v[$this->nameKey] . "</a>";
  
                $sub = $this->_li($childs, $v[$this->idKey]);

                if ($sub) {
                    $menu .= $sub;
                }
                $menu .= "</li>";
            }
        }

        if ($menu) {
            $menu .= "</ul>";
        }

        return $menu;
    }

    /**
     * Устанавливает ключи
     * @param string $IdKey
     * @param string $ParentIdKey
     * @param string $NameKey
     * @throws Exception
     */
    public function setKeys($idKey = NULL, $parentIdKey = NULL, $nameKey = NULL, $urlKey = NULL, $matchKey = NULL, $itemClassKey = NULL){    
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
        
        if (empty($nameKey)) {
            throw new Exception ('Название ключа nameKey не может быть пустым');
        }
        else{
            $this->nameKey = $nameKey;
        }
        
        if (empty($urlKey)) {
            throw new Exception ('Название ключа urlKey не может быть пустым');
        }
        else{
            $this->urlKey = $urlKey;
        }
        
        if (empty($matchKey)) {
            throw new Exception ('Название ключа matchKey не может быть пустым');
        }     
        else{
            $this->matchKey = $matchKey;
        }
        
        if (empty($itemClassKey)) {
            throw new Exception ('Название ключа itemClassKey не может быть пустым');
        }     
        else{
            $this->itemClassKey = $itemClassKey;
        }
    }

    /**
     * Устанавливает параметры
     * @param array $list
     * @param int  $id
     * @param int $c Счетчик отступов
     * @param int $selectedid
     */
    public function setParams(array $list, $id = 0) {
        $this->list = $list;
        $this->id = (int) $id;
    }

    public function show() {
        if($this->idKey == NULL || $this->parentIdKey == NULL || $this->nameKey == NULL || $this->urlKey == NULL || $this->matchKey == NULL || $this->itemClassKey == NULL){
            throw new Exception ('Не задано именя ключа');
        }
        return $this->_li($this->list, $this->id);
    }
    
    /**
     * css класс current для текущих пунктов
     * @param string $alias_new
     * @return string
     */
    protected function _setActiveClass($match) { 
        if (empty($match)){
            return '';
        }
        $activ_url = trim($_SERVER['REQUEST_URI'], '/');
        return strpos($activ_url, $match) !== FALSE || ($match == 'main' && $_SERVER['REQUEST_URI'] == '/') ? $this->liClassActive : '';
        
    }

}

