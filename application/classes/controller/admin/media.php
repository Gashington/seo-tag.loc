<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Media extends Controller_Admin {

    // имя контроллера
    protected $controller;
    // папка с медиафайлами
    protected $dir;
    protected $errors = array();
    protected $mess = '';
    // валидные типы файлов для загрузки
    protected $valid_types = array('jpg', 'png', 'gif', 'zip', 'pdf', 'xlsx', 'xls', 'docx', 'rar');

    public function before() {
        parent::before();
        $this->controller = Request::current()->controller();
        $this->dir = Kohana::$config->load('conf.dir_upload_media');
    }

    public function action_index() {

        $files = scandir($this->dir);

        $content = View::factory('admin/media/index', array(
                    'controller' => $this->controller,
                    'files' => $files,
                    'dir' => $this->dir,
                    'files_types' => $this->valid_types
        ));
        // Вывод в шаблон
        $this->template->title = 'Медиафайлы';
        $this->template->content = array($content);
    }

    public function action_add() {

        if (!empty($_POST['submit'])) {
            $file = $_FILES['mediafile'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            //if (empty($ext))
            //return false;
            $file_name = $this->get_lat_from_ru($file['name']);

            $file_name = UTF8::strtolower($this->get_slag($file_name));
            $file_name = str_replace($ext, '-' . date('Y-m-d'), $file_name);
            $file_name = $file_name . '.' . $ext;


            // create validation object
            $validation = Validation::factory($_FILES)
                    ->rule('mediafile', 'Upload::not_empty')
                    ->rule('mediafile', 'Upload::type', array(':value', $this->valid_types))
                    ->rule('mediafile', 'Upload::size', array(':value', '5M'))
                    ->labels(array(
                'mediafile' => 'Файл'
            ));


            if ($validation->check()) {
                $uploaded = Upload::save($_FILES['mediafile'], $file_name, $this->dir);
                $this->request->redirect('admin/' . $this->controller);
            }
            $this->errors = $validation->errors('validation');
        }

        $content = View::factory('admin/' . $this->controller . '/add', array(
                    'controller' => $this->controller,
        ));

        $this->template->content = array($content);
        $this->template->title = 'Добавить файл';
        $this->template->mess = $this->mess;
        $this->template->errors = $this->errors;
    }

    public function action_delete() {
        $filename = trim($this->request->param('params'));
        if (file_exists($this->dir . '/' . $filename)) {
            unlink($this->dir . '/' . $filename);
        }
        $this->request->redirect('admin/' . $this->controller);
    }

    private function get_lat_from_ru($text) {
        return str_replace(
                array('Ё', 'Ё', 'Ж', 'Ж', 'Ч', 'Ч', 'Щ', 'Щ', 'Щ', 'Ш', 'Ш', 'Э', 'Э', 'Ю',
            'Ю', 'Я', 'Я', 'ч', 'ш', 'щ', 'э', 'ю', 'я', 'ё', 'ж', 'A', 'Б', 'В', 'Г',
            'Д', 'E', 'З', 'И', 'Й ', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У',
            'Ф', 'Х', 'Ц', 'Ы', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л',
            'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х ', 'ц', 'ы', 'Ъ', 'ъ', 'Ь',
            'ь'), array('YO', 'Yo', 'ZH', 'Zh', 'CH', 'Ch', 'SHC', 'SHc', 'Shc', 'SH',
            'Sh', 'YE', 'Ye', 'YU', 'Yu', 'YA', 'Ya', 'ch', 'sh', 'shc', 'ye', 'yu',
            'ya', 'yo ', 'zh', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'Y', 'K', 'L',
            'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'X', 'a', 'b', 'v',
            'g', 'd', 'e', 'z', 'i', 'y', 'k', ' l', 'm', 'n', 'o', 'p', 'r', 's', 't',
            'u', 'f', 'h', 'c', 'x', '""', '"', "''", "'"), $text);
    }

    private function get_slag($str) {
        $str = preg_replace('/[^A-Za-z0-9]+/', '', $str);
        return $str;
    }

}