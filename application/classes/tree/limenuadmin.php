<?php

defined('SYSPATH') or die('No direct script access.');


/**
 * Вывод дерева списков категорий option
 */
class Tree_Limenuadmin implements Tree_Tree {

    /**
     * Названия ключа массива с родительским id
     * @var string 
     */
    protected  $parentIdKey = NULL;

    /**
     * Названия ключа массива с id
     * @var string 
     */
    protected  $idKey = NULL;

    /**
     * Название ключа имени ссылки
     * @var string 
     */
    protected  $nameKey = NULL;
    
    

    /**
     * Массив категорий
     * @var array() 
     */
    protected  $list = array();
      
    protected  $ulClassDeep = 'deep';  
    protected $ulClassParent = 'parent';
   
    protected $urlEdit = 'edit';
    protected $urlDelete = 'delete';
    
    protected $urlEditName = '<i class="icon-edit"></i>';
    protected $urlDeleteName = '<i class="icon-remove"></i>';
    /**
     * li вложенный список ссылок/категорий
     * @param array $list
     * @param int $id
     * @param string $alias
     * @return string html список дерева меню / категорий
     */
    protected function _li(array $list, $id = 0) {
        $c = 0;
        $id = empty($id) ? 0 : (int) $id;
        $menu = false;
        $childs = $list;
        $url_base = url::base().'admin/menues';

        foreach ($list as $k => $v) {
            //html::pr($v,1);
            if ($v[$this->parentIdKey] == $id) {

                if (!$menu) {
                    $menu = $id ? "<ul class='$this->ulClassDeep'>" : "<ul class='$this->ulClassParent'>";
                }
                unset($childs[$k]);               
                
                $menu .= "<li class='item$c'>";                         
                $c++;
                $menu .= $v[$this->nameKey];
                $menu .= " <a href='$url_base/{$this->urlEdit}/{$v[$this->idKey]}'>{$this->urlEditName}</a>";
                $menu .= " <a href='$url_base/{$this->urlDelete}/{$v[$this->idKey]}'>{$this->urlDeleteName}</a>";
  
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
    public function setKeys($idKey = NULL, $parentIdKey = NULL, $nameKey = NULL){    
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
        if($this->idKey == NULL || $this->parentIdKey == NULL || $this->nameKey == NULL){
            throw new Exception ('Не задано именя ключа');
        }
        return $this->_li($this->list, $this->id);
    }
    
    

}

