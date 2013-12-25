<?php

defined('SYSPATH') or die('No direct script access.');

return array(
    /**
     * Адмика
     */
    //Управление виджетами view
    'admin_widget_config_label' => 'На каких стр. отображать. Пример: all - на всех; /^\/$/ - на главной; /docs/,/catalog/ - на стр. катлога и документов',
    
    // добавление страниц
    'admin_page_alias_label' => '*Alias. Должен быть уникален для каждой страницы. Константы - main (текст на главной),yandexmapping (для вставки карты),contact (текст в контактах)',
    
    // Пагинация
    'Next' => 'Вперед',
    'First' => '&#171;',
    'Last' => '&#187;',
    'Previous' => 'Назад',
    // Страница 404
    'alt_img_404' => 'Страница не найдена',
    'title_link_404' => 'Вернуться на главную',
    // Логотип
    'title_link_logo' => 'Перейти на главную',
    'alt_img_logo' => 'Логотип',
    // сообщение о заказе
    'order_msg' => 'Ваш заказ принят!',
    // контакты отправлены
    'contact_msg' => 'Ваше сообщение отправлено!',
    // надпись подробнее в блогах
    'more_link' => 'Дальше...',
    // поиск
    'w_search' => 'поиск по сайту',
    'empty_search' => 'По вашему запросу ничего не найдено',
    // тексты для mail
    'mail_order' => 'Cообщение из формы заказа на сайте',
    'mail_orderform' => 'Cообщение из формы заказа',
    'mail_backcall' => 'Заказ звонка',
    'mail_contact' => 'Cообщение из формы обратной связи на сайте',
    // форма заказа, контакты
    'form_attantion' => 'поля, помеченные *, обязательны для заполнения',
    'form_label_name' => 'Ваше имя',
    'form_label_email' => 'Электронный адрес',
    'form_label_tel' => 'Телефон',
    'form_label_indexpost' => 'Индекс',
    'form_label_adress' => 'Адрес',
    'form_label_more' => 'Адрес доставки',
    'form_label_message' => 'Сообщение',
    'form_label_review' => 'Ваш отзыв',
    'button_toggle_review' => 'Оставить отзыв',
    'form_label_in_total' => 'Итоговая стоимость заказа',
    // запись в минекорзине
    'w_smallcart_empty' => 'Нет товаров',
);