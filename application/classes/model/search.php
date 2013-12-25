<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Модель блога
 */

class Model_Search extends Model {

    protected $min_word = 3;  
    
    
    public function get_min_word(){
        return $this->min_word;
    }
    /*
     * Морфология
     * $lang = 'ru_RU';
     * $lang = 'en_EN'
     */

    /*public function get_wordroot($words = array(), $lang = 'ru_RU') {

        require_once($_SERVER['DOCUMENT_ROOT'] . '/application/classes/phpmorphy/src/common.php');
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/application/classes/phpmorphy/dicts';
        $opts = array(
            'storage' => PHPMORPHY_STORAGE_FILE,
            'with_gramtab' => true,
            'predict_by_suffix' => true,
            'predict_by_db' => true
        );

        try {
            $morphy = new phpMorphy($dir, $lang, $opts);
        } catch (phpMorphy_Exception $e) {
            die('Error occured while creating phpMorphy instance: ' . $e->getMessage());
        }
        try {
            $wordroots = $morphy->getPseudoRoot($words);

            if (false === $wordroots) {
                return false;
            }
            else
                return $wordroots;
        } catch (phpMorphy_Exception $e) {
            die('Error occured while text processing: ' . $e->getMessage());
        }
    }*/

    /**
     * 
     * @param string $text
     * @param array $words
     * @return Сочетания с подсветкой <b class='match'/>
     */
    protected function set_marker($text, array $words) {
        foreach ($words as $k => $v) {
            if (UTF8::strlen($v) < $this->min_word){
                 unset($words[$k]);
            }      
        }
        $words = implode('|', $words);
        $text = preg_replace('/([\s]*[[:punct:]]*[\s]*)(' . $words . ')([\s]*[[:punct:]]*[\s]*)/ui', '\\1<span class="match">\\2</span>\\3', $text);

        return $text;
    }
  

}

?>