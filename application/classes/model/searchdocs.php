<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Searchdocs extends Model_Search {
    
    
    public function get_categories($row, $value, $s = '=') {
        $query = DB::select()
                ->from('categories')
                ->where("$row", "$s", $value);
        return $query->execute()->as_array();
    }
    
    
    public function get_search_docs($words, $rows) {
        $str = '';
        foreach ($words as $v) {
            if (UTF8::strlen($v) >= $this->min_word)
                $str .= '*' . $v . '* +';
        }
        $str = trim($str, '+');

        $query = DB::query(Database::SELECT, "SELECT  * FROM `contents`
                JOIN `categories` ON `categories`.`cat_id` = `contents`.`cont_cat_id`
                WHERE MATCH ($rows) 
                AGAINST (:str IN BOOLEAN MODE)");

        $query->param(':str', $str);

        $contents = $query->execute()->as_array();

        // добавляем имя родительской категории
        foreach ($contents as $k => $v) {
            $parent_id = $v['cat_parent_id'];
            $parent_names = $this->get_categories('cat_id', $parent_id);
            if (!empty($parent_names)) {
                $contents[$k]['cat_parent_name'] = $parent_names[0]['cat_name'];
                $contents[$k]['cat_parent_alias'] = $parent_names[0]['cat_alias'];
            }
        }

        return $this->set_info_search_docs($contents, $words);
    }

    /*
     * Формирует информацию для вывода результата поиска в документах
     */

    private function set_info_search_docs($contents, $words) {

        $search_res = array();
        //html::pr($contents);
        foreach ($contents as $k => $v) {
            $c[$k] = array();
            foreach ($words as $key => $w) {
                $c1 = substr_count(UTF8::strtoupper($v['cont_tiser']), UTF8::strtoupper($w));
                $c2 = substr_count(UTF8::strtoupper($v['cont_body']), UTF8::strtoupper($w));
                $c3 = substr_count(UTF8::strtoupper($v['cont_name']), UTF8::strtoupper($w));
                $c[$k][] = $c1 + $c2 + $c3;
            }
            if (!empty($v['cat_parent_alias']))
                $url = 'docs/' . $v['cat_parent_alias'] . '/' . $v['cat_alias'] . '/' . $v['cont_id'];
            else
                $url = 'docs/' . $v['cat_alias'] . '/' . $v['cont_id'];

            $search_res[] = array(
                'name' => $this->set_marker($v['cont_name'], $words),
                'label' => 'Блог',
                'tiser' => $this->set_marker($v['cont_tiser'], $words),
                'body' => $this->set_marker($v['cont_body'], $words),
                'link' => $url,
                'count' => array_sum($c[$k]),
            );
        }
        return $search_res;
    }
}
