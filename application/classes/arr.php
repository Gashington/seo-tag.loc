<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Мой Класс расширяющий хелперы URL
 */

class Arr extends Kohana_Arr {

    /**
     *
     * @param array $array Входной массив
     * @param string $by По какому ключу сортировать
     * @return array Отсортированный массив
     */
    public static function multi_sort($array, $by) {
        $result = array();
        foreach ($array as $val) {
            if (!is_array($val) || !key_exists($by, $val)) {
                continue;
            }
            end($result);
            $current = current($result);
            while ($current[$by] > $val[$by]) {
                $result[key($result) + 1] = $current;
                prev($result);
                $current = current($result);
            }
            $result[key($result) + 1] = $val;
        }
        return $result;
    }

}

?>