<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Основная модель документов
 */
class Model_Tagscloud extends Model {

    private $tbl_name_contents = 'contents';

    public function get_tags(array $tables){

        $result = '';

        $all_datas = DB::select($tables['name_field'])->from($tables['name_table'])->execute()->as_array();

        foreach($all_datas  as $v){
            $result .= $v[$tables['name_field']] . ',';
        }

        $result = trim($result , ',');

        $array_tags = explode(',',$result);
        $func = function($par){
            return trim(utf8::strtolower($par));
        };

        return array_map($func, $array_tags);
    }

    public function get_contents($tag, $limit = NULL, $offset = NULL, $order = NULL) {


        $limit = (int) $limit;
        $offset = (int) $offset;

        //url::pr($cats_daughter,1);
        $query = DB::select()->from($this->tbl_name_contents)->where('cont_meta_k', 'rlike', ".$tag.");

       /* $query = DB::query(Database::SELECT, "SELECT  * FROM `contents`
                JOIN `categories` ON `categories`.`cat_id` = `contents`.`cont_cat_id`
                WHERE  `contents`.`cont_meta_k`  RLIKE 'php'");*/

        //$query->and_where();

        /*if (!Auth::instance()->logged_in('admin')) {
            $query->and_where('cont_show', '=', '1');
        }

        if ($limit != 0) {
            $query->limit($limit)->offset($offset);
        }
        if (!empty($order)) {
            list($name, $type) = $order->get_order_data();
            $query->order_by($name, $type);
        } else {
            $query->order_by('cont_order')->order_by('cont_id', 'DESC');
        }*/

        $res =  $query->execute()->as_array();
        html::pr($res,1);
    }
}