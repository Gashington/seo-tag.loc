<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Вывод дерева списков категорий option
 */
class Tree_Lidoccatsimple implements Tree_Tree {

    /**
     * Инициализачия счетчика alias
     * @var int
     */
    private static $alias_count = 0;

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
    protected $aliasKey = NULL;

    /**
     * Массив категорий
     * @var array 
     */
    protected $list = array();
    
    protected $ulClassDeep = 'deep';  
    protected $ulClassParent = 'parent';
    protected $liClassActive = ' active';
    
    /**
     * Путь к контроллеру
     * @var string
     */
    protected $url = NULL;

    /**
     * li вложенный список ссылок/категорий
     * @param array $list
     * @param int $id
     * @param string $alias
     * @return string html список дерева меню / категорий
     */
    protected function _li(array $list, $id = 0, $alias = '') {
        $n = 0;
        $id = empty($id) ? 0 : (int) $id;
        $menu = false;
        $childs = $list;
        foreach ($list as $k => $v) {
            //html::pr($v,1);
            if ($v[$this->parentIdKey] == $id) {

                if (!empty($v[$this->aliasKey])) {
                    $alias_new = $this->_get_alias($alias, $v[$this->aliasKey]);
                } else {
                    $alias_new = NULL;
                }

                if (!$menu) {
                    $menu = $id ? "<ul class='$this->ulClassDeep'>" : "<ul class='$this->ulClassParent'>";
                }
                unset($childs[$k]);

                //$active_class = $this->_setActiveClass($v[$this->matchKey]);          
                //$item_class = empty($v[$this->itemClassKey]) ? '' : ' ' . $v[$this->itemClassKey];
                            
                $menu .= "<li class='item$n'>";
                $n++;
                $menu .= "<a href='$this->url/$alias_new'>" . $v[$this->nameKey] . "</a>";

                $sub = $this->_li($childs, $v[$this->idKey], $alias_new);

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
        return $this->_li($this->list, $this->id);
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
