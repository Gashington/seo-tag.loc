<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Мой Класс расширяющий хелперы HTML
 */

class HTML extends Kohana_HTML {

    /**
     * Аналог print_r
     * @param array or string $str
     * @param string $die
     */
    public static function pr($str, $die = null) {
        echo "<pre>";
        print_r($str);
        echo "</pre>";
        if ($die != null)
            die('Сарботал die');
    }

    /**
     * Фильтр входящих параметров
     * @param string or int $str
     * @param string $type Тип данных, в который нужно предствить
     * @return string or int
     */
    public static function filter($str, $type = NULL) {
        $str = trim(strip_tags($str));
        $str = str_replace("#", "#", $str);
        $str = str_replace("%", "%", $str);
        if (!empty($type))
            settype($str, $type);
        return $str;
    }

    /**
     * Перевод вермени в человекопонятную форму
     * @param unix time string $time
     * @return string
     */
    public static function human_ru_time($time) {
        
        $month_name = html::ru_month(date('n', $time));

        $month = $month_name[date('n', $time)];
        $day = date('j', $time);
        $year = date('Y', $time);
        $hour = date('G', $time);
        $min = date('i', $time);

        $date = $day . ' ' . $month . ' ' . $year . ' г. в ' . $hour . ':' . $min;

        $dif = time() - $time;

        if ($dif < 59) {
            return $dif . " сек. назад";
        } elseif ($dif / 60 > 1 and $dif / 60 < 59) {
            return round($dif / 60) . " мин. назад";
        } elseif ($dif / 3600 > 1 and $dif / 3600 < 23) {
            return round($dif / 3600) . " час. назад";
        } else {
            return $date;
        }
    }
    
    /**
     * Название месяцев на русском по номеру
     * @param int $n номер месяца
     * @param bool $end с окончание или без
     * @return string
     */
    public static function ru_month($n, $end = false){
        $month_name =
                array(
                    1 => 'января',
                    2 => 'февраля',
                    3 => 'марта',
                    4 => 'апреля',
                    5 => 'мая',
                    6 => 'июня',
                    7 => 'июля',
                    8 => 'августа',
                    9 => 'сентября',
                    10 => 'октября',
                    11 => 'ноября',
                    12 => 'декабря'
                );
        $month_name_end =
                array(
                    1 => 'январь',
                    2 => 'февраль',
                    3 => 'март',
                    4 => 'апрель',
                    5 => 'май',
                    6 => 'июнь',
                    7 => 'июль',
                    8 => 'август',
                    9 => 'сентябрь',
                    10 => 'октябрь',
                    11 => 'ноябрь',
                    12 => 'декабрь'
                );
        return $end ?  $month_name_end[$n] : $month_name[$n];
    }
    
    /**
     * Выходные дни РБ
     * @param int $d день
     * @param int $m месяц
     * @return boolean
     */
    public static function ru_hollyday($d, $m){
        $hollyday = array(
            1   => 1,
            7   => 1,
            8   => 3,
            1   => 5,
            9   => 5,
            3   => 7,
            7   => 11,
            25  => 12,
            // нет радуницы
        ); 
        
        if (! empty ($hollyday[$d]) && $hollyday[$d] == $m) {
            return true;
        }
        else {
            return false;
        }
    }


    /**
     * День недели на русском
     * @param int $n
     * @return string
     */
    public static function ru_week($n, $more = FALSE){
        $week_name =
                array(
                    0 => 'вс',
                    1 => 'пн',
                    2 => 'вт',
                    3 => 'ср',
                    4 => 'чт',
                    5 => 'пт',
                    6 => 'сб',    
                );
        $week_name_more =
                array(
                    0 => 'воскресенье',
                    1 => 'понедельник',
                    2 => 'вторник',
                    3 => 'среда',
                    4 => 'четверг',
                    5 => 'пятница',
                    6 => 'суббота',    
                );
        return $more ? $week_name_more[$n] : $week_name[$n];
    }
                             
    /**
     * Перобразует строку даты формата 2012-11-29 в метку времени
     * @param string $str формат 2012-11-29
     * @return int метка фремени
     */
    public static function mktime_from_input_date($str){
        $date_arr = explode('-', $str);
        return mktime(0, 0, 0, $date_arr[1], $date_arr[2], $date_arr[0]);
    }

    /**
     * Удаляет картинки из media/uploads; пути беруться из контента
     * @param str $content Html контент, где ищеццо картико
     * @return boolean
     */
    public static function del_imgs_from_content($content) {
        preg_match_all("/<\s*img[^>]*src=[\"|\'](.*?)[\"|\'][^>]*\/*>/i", $content, $matches);
        foreach ($matches[1] as $img) {
            $img_small = str_replace('media/uploads/', 'media/uploads/small_', $img);
            if (file_exists(url::root() . $img_small))
                unlink(url::root() . $img_small);
            if (file_exists(url::root() . $img))
                unlink(url::root() . $img);
        }
        return true;
    }

    public static function doc_is_empty($txt) {
        return isset($txt) ? $txt : '';
    }

}