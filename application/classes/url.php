<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Мой Класс расширяющий хелперы URL
 */

class URL extends Kohana_URL {

    /**
     * Текущий url cnhfybws
     * @param string $long total/short Полный и короткий гкд
     * @param sring $http Видт протокола HTTP или SHTTP
     * @param bool  $clear Чистый урл без GET переменных
     * @return sting Текущий url
     */
    public static function curr($long = 'total', $http = 'http', $clear = false) {
        if ($long == 'total') {
            $url = $http . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else {
            $url = $_SERVER['REQUEST_URI'];
        }
        if ($clear == true) {
            $query = strstr($url, '?');
            $url = str_replace($query, '', $url);
        }
        return $url;
    }

    /**
     * Это главная?
     */
    public static function is_front() {
        $curr = trim(self::curr('total', 'http', true), '/');
        $base_url = trim(url::base(), '/');
        return $curr == $base_url ? true : false;
    }

    /**
     * Сравнение текущей страницы с $page
     */
    public static function is_page($page) {
        return strpos(self::curr(), $page) !== FALSE ? true : false;
    }

    /**
     * Путь до css
     */
    public static function css($lib = FALSE) {
        if ($lib == TRUE)
            return url::base() . 'media/css/' . $lib . '/';
        else
            return url::base() . 'media/css/';
    }

    /**
     * Путь до js
     */
    public static function js($lib = FALSE) {
        if ($lib == TRUE)
            return url::base() . 'media/js/' . $lib . '/';
        else
            return url::base() . 'media/js/';
    }

    /**
     * Добавляет ксласс current к активным ссылкам;
     * если передан только $url_current, ищется совпадение url c контроллером
     * если два параметра, ищется совпадения текущего url с url пункта меню
     */
    public static function active($match = 'NULL') {
        if (empty($match))
            return '';

        $url_current = self::curr('short');
        if ($url_current == '/' && $match == 'main')
            return ' current';
        else
            return strpos($url_current, $match) !== FALSE ? ' current' : '';
    }

    /**
     * Формирует хлебные крошки, делая последний итем НЕ ссылкой
     * @param array $breadcrumb $breadcrumb[] = array('url'=> '', 'name' => '')
     * @return string html
     */
    public static function breadcrumb($breadcrumb) {
        if (empty($breadcrumb)) {
            return '';
        }
        $count = count($breadcrumb) - 1;
        $separator = Kohana::$config->load('conf.breadcrumb_separator');
        $breadcrumb_html = '<nav><ul>';
        foreach ($breadcrumb as $k => $v) {
            $base_url = $v['url'] == '/' ? '' : url::base();
            $txt = $count > $k ? "<a href='{$base_url}{$v['url']}'>{$v['name']}</a>" . '<span class="separator">' . $separator . '</span>' : "<span class='last_name'>{$v['name']}</span>";
            $breadcrumb_html .= "<li>$txt</li>";
        }
        $breadcrumb_html .= '</ul></nav>';
        return $breadcrumb_html;
    }

    /**
     * Вызываемый Контроллер
     */
    public static function controller_current() {
        return Request::initial()->controller();
    }

    /**
     * Путь до корневой диретории без слеша в конце
     */
    public static function root() {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Полный путь алиасов в документах для вьюсов
     * @param array  $item Массив категорий
     * @return string
     */
    public static function doc_url_alias($item) {
        $alias = '';
        foreach ($item as $cat) {
            $alias .= $cat['cat_alias'] . '/';
        }
        return $alias;
    }

    /**
     * Дерево категорий в строку в документах для вьюсов
     * @param array  $item Массив категорий
     * @return string
     */
    public static function doc_cats($item) {
        $cat_str = '';
        foreach ($item as $cat) {
            $cat_str .= $cat['cat_name'] . '/';
        }
        return UTF8::strtolower(trim($cat_str, '/'));
    }
    
    /**
     * Корректный алиас Требует доработки
     * @param string $str
     * @return string Возвращает корректный алиас
     */
    public static function alias_correct($str) {

        $alias = str_replace(
                array('Ё', 'Ё', 'Ж', 'Ж', 'Ч', 'Ч', 'Щ', 'Щ', 'Щ', 'Ш', 'Ш', 'Э', 'Э', 'Ю',
            'Ю', 'Я', 'Я', 'ч', 'ш', 'щ', 'э', 'ю', 'я', 'ё', 'ж', 'A', 'Б', 'В', 'Г',
            'Д', 'E', 'З', 'И', 'Й ', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У',
            'Ф', 'Х', 'Ц', 'Ы', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л',
            'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х ', 'ц', 'ы', 'Ъ', 'ъ', 'Ь',
            'ь'), array('YO', 'Yo', 'ZH', 'Zh', 'CH', 'Ch', 'SHC', 'SHc', 'Shc', 'SH',
            'Sh', 'YE', 'Ye', 'YU', 'Yu', 'YA', 'Ya', 'ch', 'sh', 'shc', 'ye', 'yu',
            'ya', 'yo', 'zh', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'Y', 'K', 'L',
            'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'X', 'a', 'b', 'v',
            'g', 'd', 'e', 'z', 'i', 'y', 'k', ' l', 'm', 'n', 'o', 'p', 'r', 's', 't',
            'u', 'f', 'h', 'c', 'x', '""', '"', "''", "'"), $str);

        return preg_replace('/([^a-zA-Z0-9\-])/', '', $alias);
    }

}