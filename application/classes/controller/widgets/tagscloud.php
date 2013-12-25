<?php
defined('SYSPATH') or die('No direct script access.');
/*
 * Виджет "Слайдер работ на главной"
 */

class Controller_Widgets_Tagscloud extends Controller_Widgets {
    // Шаблон виждета
    public $template = 'widgets/w_tagscloud';
    /**
     * Размер ширфта
     * @var int
     */
    private $font_size = 12;

    // здесь мы будем обращаться к модели для получения меню
    public function action_index() {

        if (!$tags = $this->cache->get('cache_tags')) {

            $tables = array('name_table' => 'contents', 'name_field' => 'cont_meta_k');

            $array_tags = Model::factory('tagscloud')->get_tags($tables);

            $tags = array();

            foreach ($array_tags as $k => $v){
                if(in_array($array_tags[$k], $array_tags)){
                    $tags[$array_tags[$k]]['font_size'] = empty($tags[$array_tags[$k]]['font_size']) ? $this->font_size : $tags[$array_tags[$k]]['font_size'] + 2;
                }
            }

            $this->cache->set('cache_tags', $tags);
        }

        $this->template->tagscloud = $tags;

    }
}