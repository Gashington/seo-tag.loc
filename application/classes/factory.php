<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Общий класс фабрики для управления контеном и деревом меню
 */
class Factory{   
    /**
     * Установить класс и вернуть объект
     * @param string $type Название класса
     * @return \type Объект \ Исключение
     * @throws Exception
     */
    static public function set($type) {
        try{
            if (class_exists($type))
                return new $type();
            else{
                throw new Exception('Класс ' . $type . ' не существует!');
            }
        }
        catch (Exception $e){
           echo $e->getMessage(); 
           die; 
        }
    }
}