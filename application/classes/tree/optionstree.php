<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Вывод дерева списков категорий option
 */
class Tree_Optionstree implements Tree_Tree {

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
    protected function _options(array $list, $id = 0, $n = 0, $selectedid = NULL) {

        $options = false;
        $childs = $list;
        $n++;

        foreach ($list as $k => $v) {
            if ($v[$this->parentIdKey] == $id) {
                unset($childs[$k]);
                $selected = $selectedid == $v[$this->idKey] ? " selected='selected'" : '';
                $options .= "<option value=" . $v[$this->idKey] . "$selected>"
                        . str_repeat('-', $n) . $v[$this->nameKey]
                        . "</option>";
                $sub = $this->_options($childs, $v[$this->idKey], $n, $selectedid);
                if ($sub) {
                    $options .= $sub;
                }
            }
        }
        return $options;
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
    public function setParams(array $list, $id = 0, $n = 0, $selectedid = NULL){
        $this->list = $list;
        $this->id = (int)$id;
        $this->n = (int)$n;
        $this->selectedid = (int)$selectedid;
    }

    public function show() {
        if($this->idKey == NULL || $this->parentIdKey == NULL || $this->nameKey == NULL){
            throw new Exception ('Не заданы имена ключей');
        }
        return $this->_options($this->list, $this->id,  $this->n, $this->selectedid);
    }

}
