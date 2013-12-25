<?php

defined('SYSPATH') or die('No direct script access.');
/*
 *  Все настройки можно переопределять /admin/conf
 */
return array(
    /*
     * Обязательные настройки
     */
    // компрессия css
    'css_compress' => false,
    // определять ли информацию о городе с помощью класса SxGeo и базы SxGeoCity.dat
    'city_location' => false,
    // определять ли версию браузера
    'get_app' => true,
    // нужен ли редирект со старых сайтов на заглушку; обязательно! br_version = true
    'old_br_redirect' => true,
    // разделитель хлебных крошек
    'breadcrumb_separator' => '/',
    // имя сайта
    'site_name' => 'Имя сайта',
    // это будет использоваться по дефолту, например для главной страницы
    'title' => 'Главная страница',
    'meta_keywords' => 'meta_keywords',
    'meta_description' => 'meta_description',
    'site_description' => 'site_description',
    // папка с контроллерами виджетов
    'widget_folder' => 'widgets',
    'mail' => 'goper@tut.by',
    
    /*
     * Конец обязательных настроек
     */
    // показывать отзывы?
    'show_reviews' => 0,
    
    // дефолтная ширина и высота превью изображений для которых не заданы спец. настройки
    'img_preview_w' => 120,
    'img_preview_h' => 200,    
    
    // дефолтная ширина и высота превью - документы
    'img_preview_doc_w' => 250,
    'img_preview_doc_h' => 180,
    
    // дефолтная ширина и высота превью - страниц
    'img_preview_page_w' => 250,
    'img_preview_page_h' => 180,
    
    // дефолтная ширина и высота превью - галерея категории
    'img_preview_galcat_w' => 270,
    'img_preview_galcat_h' => 180,
    // дефолтная ширина и высота превью - собственно категории
    'img_preview_gal_w' => 133,
    'img_preview_gal_h' => 89,
       
    // дефолтная ширина и высота доп. изображения для слайдера
    'img_add_preview_slider_w' => 120,
    'img_add_preview_slider_h' => 120,
    
    // пути к папкам с файлами и изображениями
    'dir_upload_gallery' => 'media/uploads/gallery',
    'dir_upload_media' => 'media/uploads/mediafiles',
   
    'dir_upload_slider' => 'media/uploads/slider',
    'catalog_text' => 'Оисание каталога',
    'dir_upload_preview' => 'media/uploads/docs_preview',
    
    // количество выводимых докуметов в админке и fron-end
    'items_per_page_docs' => 10,
    'items_per_page_docs_admin' => 10,
    // количество выводимых категорий в галерее
    'items_per_page_gcats' => 6,
    // количество выводимых на стр заказо
    'items_per_page_orders_admin' => 10,
    
    // вопрос-ответ
    'show_answers' => 0,
);
?>