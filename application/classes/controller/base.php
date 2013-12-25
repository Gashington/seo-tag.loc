<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Базовый класс
 */
class Controller_Base extends Controller_Template {

    public $cache;
    public $captcha;
    public $session;
    protected $main_menu;
    protected $breadcrumb = array();
    protected $site_info = NULL;
    protected $menu = array();

    public function before() {
        parent::before();

        // используем язык
        I18n::lang('ru');

        // иницилизация кеширование в файл
        $this->cache = Cache::instance('file');
        // иницилизация сессий (стандарные)
        $this->session = Session::instance();
        // капча
        if (class_exists('Captcha')) {
            $this->captcha = Captcha::instance();
        }

        $css_array = Kohana::$config->load('css');
        if (Kohana::$config->load('conf.css_compress') == true) {
            $this->template->css = array(compression::compressCode($css_array, 'media/css/compressed.css', 'text/css'));
        } else {
            $this->template->css = $css_array;
        }

        // поучить все меню сайта
        $this->template->menu = $this->_get_menu();

        if (!$this->site_info = $this->cache->get('cache_site_info')) {
            $this->site_info = Model::factory('main')->site_info();
            $this->cache->set('cache_site_info', $this->site_info);
        }

        // Вывод в шаблон переменных из кофига или по умолчанию
        $this->template->site_name = $this->site_info['name_site'];
        $this->template->meta_description = $this->site_info['meta_d_site'];
        $this->template->meta_keywords = $this->site_info['meta_k_site'];
        $this->template->title = $this->site_info['title_site'];
        $this->template->site_description = $this->site_info['description_site'];
        $this->template->adress_site = $this->site_info['adress_site1'];
        $this->template->adress_add = $this->site_info['adress_site2'];
        $this->template->mail_site = $this->site_info['mail_site'];
        $this->template->icq_site = $this->site_info['icq_site'];
        $this->template->tel_mob_site = empty($this->site_info['tel_mob_site']) ? array() : explode(',', $this->site_info['tel_mob_site']);
        $this->template->tel_stat_site = empty($this->site_info['tel_stat_site']) ? array() : explode(',', $this->site_info['tel_stat_site']);
        $this->template->yandex_metrika = $this->site_info['yandex_metrika'];
        $this->template->google_analytics = $this->site_info['google_analytics'];
        $this->template->meta_keywords = $this->site_info['meta_k_site'];
        $this->template->meta_description = $this->site_info['meta_d_site'];
        $this->template->owner = $this->site_info['owner_site'];
        $this->template->title = $this->site_info['title_site'];

        // если в настройка вкл - выводить город по ip
        if (Kohana::$config->load('conf.city_location') == true) {
            $this->template->city_location = $this->_get_city();
        }
        // если стоит настройка поределения приложения, делаем что-то. Действия определяются стратегией
        if (Kohana::$config->load('conf.get_app') == true) {
            new Appstrategy_Appstrategy(new Browser());
        }

        // формируем первую часть хлебных крошек главная - пункт меню (остальное - в контроллерах страниц)
        $breadcrumbs[] = array('url' => '/', 'name' => 'Главная');
        $this->breadcrumbs = $breadcrumbs;
        //$this->template->breadcrumbs = $breadcrumbs;
        $this->template->is_admin = null;
        // Подключаем стили и js
        $this->template->styles = array();
        $this->template->scripts = array();
        // Переменные по дефолту в шаблоне
        $this->template->errors = array();

        if (Auth::instance()->logged_in('admin')) {
            $this->template->is_admin = 'Режим админа';
        }
    }

    /**
     * Кортокий вызов виджета
     */
    protected function widget_load($widget) {
        // папку с контроллерами виджетов получаем из конфига
        $widget_folder = Kohana::$config->load('conf.widget_folder');
        return Request::factory($widget_folder . '/' . $widget)->execute();
    }

    /**
     * Загузка превью изобаржение (новости, категории каталога)
     * @param array $FILES
     * @param string $dir_upload Путь каталога
     * @return string $img имя изображения
     */
    protected function _upload_preview_img($FILES, $dir_upload, $w = FALSE, $h = FALSE) {
        if (!empty($FILES['images']['name'])) {
            $ext = pathinfo($FILES['images']['name'], PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'gif' || $ext == 'png' || $ext == 'jpeg') {
                $img = $this->_upload_img($FILES['images']['tmp_name'], $ext, $dir_upload, TRUE, $w, $h);
            }
            return $img;
        }
        return null;
    }

    /**
     * Загрузка изображения
     * @param string $file Путь к файлу
     * @param string $ext Расширение файла без точки
     * @param string $directory Путь к директории
     * @param bool $resize Изменять ширину?
     * @param integer $w Ширина в пикселях
     * @return string Путь к загруженному изображению
     */
    public function _upload_img($file, $ext = NULL, $directory = NULL, $resize = TRUE, $w = FALSE, $h = FALSE) {

        if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png' && $ext != 'jpeg') {
            return false;
        }
        if ($directory == NULL) {
            $directory = 'media/uploads';
        }

        $filename = md5(rand(1, 100) . time());

        // Изменение размера и загрузка изображения
        if ($resize == TRUE) {
            $im = Image::factory($file);
            $width = Kohana::$config->load('conf.img_preview_w');
            $height = Kohana::$config->load('conf.img_preview_h');
            if ($w != FALSE) {
                $width = $w;
                //if ($im->height > Kohana::$config->load('conf.img_preview_w')) {
                //$im->resize(Kohana::$config->load('conf.img_preview_w'));
                //$im->resize($width, $height, Image::AUTO);
                //}
            }
            if ($h != FALSE) {
                $height = $h;
            }
            //else{
            ///$width = $w;
            //if ($im->height > $w) {
            //$im->resize($w);
            //}
            //}
            $im->resize($width, $height, Image::AUTO);
            $im->save("$directory/small_$filename.$ext", 85);
        }

        $im = Image::factory($file);

        $im->save("$directory/$filename.$ext", 100);

        return "$filename.$ext";
    }

    /**
     * Загрузка изображений через CKEDITOR
     * Папка - media/uploads (нуждается в доработке),\
     * путь должен браться из конфига
     */
    public function action_ckupload() {

        $file_Name = $_FILES["upload"]["tmp_name"];

        $ext = file::ext_by_mime($_FILES["upload"]["type"]);
        if ($ext == 'jpe')
            $ext = 'jpg';
        $file = $this->_upload_img($file_Name, $ext);
        $callback = $_REQUEST['CKEditorFuncNum'];
        if ($file) {
            echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $callback . '",  "/media/uploads/' . $file . '","Файл загружен" );</script>';
        } else {
            echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $callback . '",  "/media/uploads/' . $file . '","Файл не загружен" );</script>';
        }
    }

    /**
     * Отсылка почты
     * @param string $message
     * @param string $subject
     * @return boolean
     */
    protected function _send_mail($message, $subject = null, $to = false) {
        $site_name = empty($this->site_info['name_site']) ? Kohana::$config->load('conf.site_name') : $this->site_info['name_site'];
        if (!$to) {
            $email = empty($this->site_info['mail_site']) ? Kohana::$config->load('conf.mail') : $this->site_info['mail_site'];
        } else {
            $email = $to;
        }
        if ($subject == null)
            $subject = 'Сообщение с сайта ' . url::base();

        try {
            $mail = new PHPMailer();
            $mail->CharSet = 'utf-8';
            $mail->SetFrom($email, $site_name);
            $mail->AddAddress($email, $site_name);
            $mail->Subject = $subject;
            $mail->MsgHTML($message);
            $mail->Send();
            return "Message Sent";
        } catch (phpmailerException $e) {
            return $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            return $e->getMessage(); //Boring error messages from anything else!
        }
    }

    /**
     * Определение города по ip. База городов SxGeoCity.dat
     * @return array ['city'] - город
     */
    protected function _get_city() {

        $ip = $_SERVER["REMOTE_ADDR"];
        //$ip = '195.222.75.115';
        $SxGeo = new SxGeo(url::root() . '/media/datacity/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);
        $city_info = $SxGeo->getCity($ip);
        $city = empty($city_info) ? array() : $city_info;

        return $city;
    }

    /**
     * Массив всех меню на сайте
     * @return array
     */
    private function _get_menu() {

        $model = Model::factory('menues');

        if (!$menus_types = $this->cache->get('cache_menues_types')) {
            $menus_types = $model->get_menu_types();
            $this->cache->set('cache_menues_types', $menus_types);
        }

        if (empty($menus_types)) {
            $menus_types = array();
            $menus = array();
        }

        foreach ($menus_types as $k => $type) {
            $menu = $model->get_menu(null, null, null, $type['menut_id']);
            $menus[$menus_types[$k]['menut_alias']]['type_name'] = $type['menut_name'];
            $menus[$menus_types[$k]['menut_alias']]['type_h'] = $type['menut_h'];
            $menus[$menus_types[$k]['menut_alias']]['type_alias'] = $type['menut_alias'];
            $menus[$menus_types[$k]['menut_alias']]['type_id'] = $type['menut_id'];
            $menus[$menus_types[$k]['menut_alias']]['type_descr'] = $type['menut_descr'];
            $menus[$menus_types[$k]['menut_alias']]['type_order'] = $type['menut_order'];
            $menus[$menus_types[$k]['menut_alias']]['type_show'] = explode(',', $type['menut_show']);
            $menus[$menus_types[$k]['menut_alias']]['menues'] = $menu;
            $menus[$menus_types[$k]['menut_alias']]['tree'] = $model->get_li_menu_front($menus[$menus_types[$k]['menut_alias']]['menues']);
        }

        return $menus;
    }

}

?>
