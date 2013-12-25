<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Основная модель документов
 */
class Model_Docs extends Model {

    /**
     * Разбивает url с алиасами в документах и материалах и возвращает нужные параметры
     * @param string $params_str url с алиасами
     * @param string $separator Разделитель алиасов
     * @return array() [params_arr] - массив алиасов без id; ['id'] - id;['alias_last'];['alias_first']
     */
    public function get_arr_doc_alias($params_str = NULL, $separator = '/') {

        $params_str = trim($params_str);

        $params_arr = empty($params_str) ? array() : explode($separator, $params_str);

        //получение id и удаление его из массива параметров
        foreach ($params_arr as $k => $v) {
            if (is_numeric($v)) {
                $id = $params_arr[$k];
                unset($params_arr[$k]);
            }
        }
        //получение первой и посленей части алиаса
        if (!empty($params_arr)) {
            $item_alias_last = count($params_arr) - 1;
            $alias_last = $params_arr[$item_alias_last];
            $alias_first = $params_arr[0];
        }

        $pars_alias['params_arr'] = empty($params_arr) ? array() : $params_arr;
        $pars_alias['alias_str'] = empty($params_arr) ? '' : implode($separator, $params_arr);
        $pars_alias['id'] = empty($id) ? NULL : (int) $id;
        $pars_alias['alias_last'] = empty($alias_last) ? NULL : $alias_last;
        $pars_alias['alias_first'] = empty($alias_first) ? NULL : $alias_first;

        return $pars_alias;
    }
    
    /**
     * Навзание вида для активной категории
     * @param array $active_cat Активная категория
     * @return string Навзание вида
     */
    public function get_view($active_cat) {
        return empty($active_cat['cat_view']) ? '' : '_' . $active_cat['cat_view'];
    }
    
    /**
     * Название css- класса активной категории
     * @param array $active_cat
     * @return string Название css- класса активной категории
     */
    public function get_css_class($active_cat) {
        return empty($active_cat['cat_class']) ? '' : $active_cat['cat_class'];
    }
    
    /**
     * Получить id активной категории
     * @param array $active_cat
     * @return int id активной категории
     */
    public function get_catid_active($active_cat) {
        return empty($active_cat) ? NULL : (int) $active_cat['cat_id'];
    }
    
    /**
     * Массив дочерних категорий
     * @param array $list
     * @param int $id
     * @return array
     */
    public function get_daughter(array $list, $id = 0) {
        $litree = Factory::set('Tree_Daughters');
        $litree->setParams($list, $id);
        $litree->setKeys('cat_id','cat_parent_id');
        return $litree->show();
    }

    /**
     * Массев родительских категорий
     * @param array $list
     * @param int $id
     * @return array
     */
    public function get_parent(array $list, $id = 0) {
        $litree = Factory::set('Tree_Parents');
        $litree->setParams($list, $id);
        $litree->setKeys('cat_id','cat_parent_id');
        return $litree->show();
    }

    /**
     * html table список-дерево категорий
     * @param stirng $group css-класс для отцовского ul
     * @param array $list
     * @param int $id
     * @param string $url
     * @param bool $admin
     * @return string
     */
    public function get_table_admincategories(array $list, $url) {
        $litree = Factory::set('Tree_Tabledoccatadmin');
        $litree->setParams($list, $url);
        $litree->setKeys('cat_id','cat_parent_id','cat_name', 'cat_alias');
        return $litree->show();
    }
    
    /**
     * html li список-дерево категорий
     * @param stirng $group css-класс для отцовского ul
     * @param array $list
     * @param int $id
     * @param string $url
     * @param bool $admin
     * @return string
     */
    public function get_li_categories(array $list, $url) {       
        $litree = Factory::set('Tree_Lidoccatsimple');
        $litree->setParams($list, $url);
        $litree->setKeys('cat_id','cat_parent_id','cat_name', 'cat_alias');
        return $litree->show();
    }

    /**
     * Выпадающий список категорий без <select>
     * @param array $list
     * @param int $id
     * @param int $c
     * @param int $selectedid id выбранного пункта
     * @return string
     */
    public function get_tree_options(array $list, $id = 0, $n = 0, $selectedid = 0) {        
        $optionstree = Factory::set('Tree_Optionstree');
        $optionstree ->setKeys('cat_id','cat_parent_id','cat_name');
        $optionstree ->setParams($list, $id, $n, $selectedid);
        return $optionstree->show();
    }
    
    public function get_tree_fororder(array $list, $url){
        $optionstree = Factory::set('Tree_Lidoccatsorder');
        $optionstree ->setKeys('cat_id','cat_parent_id','cat_name','cat_alias');
        $optionstree ->setParams($list, $url);
        return $optionstree->show();
    }
    
    /**
     * 
     * @param string $dir путь до папки
     * @param string $img название картинки
     * @return int
     */
    public function unlink_preview($dir, $img){
        if (is_file($dir . '/' . $img)) {
            if(!unlink($dir . '/' . $img)){
                throw new Exception ('Не могу удалить ' .$img); 
            }
        }
        if(is_file($dir . '/small_' . $img)){
            if(!unlink($dir . '/small_' . $img)){
                throw new Exception ('Не могу удалить ' . '/small_'.$img); 
            };
        }
        return 1;
    }

}
