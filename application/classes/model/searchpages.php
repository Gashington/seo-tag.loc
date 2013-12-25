<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Searchpages extends Model_Searchdocs
{

    public function get_search_pages($words, $rows)
    {
        $str = '';
        foreach ($words as $v) {
            if (UTF8::strlen($v) >= $this->min_word)
                $str .= '*' . $v . '* +';
        }
        $str = trim($str, '+');

        $query = DB::query(Database::SELECT, "SELECT * FROM `pages` WHERE MATCH ($rows) AGAINST (:str IN BOOLEAN MODE)");

        $query->param(':str', $str);

        $pages = $query->execute()->as_array();
        return $this->set_info_search_pages($pages, $words);
    }

    private function set_info_search_pages($pages, $words)
    {

        $search_res = array();

        foreach ($pages as $k => $v) {
            $c[$k] = array();
            foreach ($words as $key => $w) {
                $c1 = substr_count(UTF8::strtoupper($v['content']), UTF8::strtoupper($w));
                $c2 = substr_count(UTF8::strtoupper($v['name']), UTF8::strtoupper($w));
                $c[$k][] = $c1 + $c2;
            }
            $search_res[] = array(
                'name' => $this->set_marker($v['name'], $words),
                'label' => 'Страница',
                'tiser' => $this->set_marker($v['content'], $words),
                'link' => 'page/' . $v['alias'],
                'count' => array_sum($c[$k]),
            );
        }
        return $search_res;
    }
}
