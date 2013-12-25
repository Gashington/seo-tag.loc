<?php

class Compression {

    const charset = 'UTF-8';

    /**
     * Ужимает файл и возвращает путь к нему
     * @param array $inc_array Массив подключаемых файлов
     * @param string $pathToMadeFile Путь для создания ужатого файла
     * @param string $typeOfContent Тип контента (Напр. text/css)
     * @return string Путь к ужатому файлу
     */
    public static function compressCode($inc_array, $pathToMadeFile, $typeOfContent) {
        header('Content-type:' . $typeOfContent . '; charset=' . self::charset);
        ob_start();
        self::_check($inc_array);       
        foreach ($inc_array as $v) {
            require $v;
        }
        $code = ob_get_contents();
        ob_end_clean();
        $codeCompressed = self::_compress($code);
        return self::_save($pathToMadeFile, $codeCompressed);
    }
    
    /**
     * Комперсиия кода
     * @param string $code
     * @return string сжатый код
     */
    private static function _compress($code) {
        $code = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code);
        $code = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $code);
        return $code;
    }
    
    /**
     * 
     * @param string $path путь для сохранения сжатого файла
     * @param string $code сжатый код
     * @return string Путь сохраненного сжатого файла
     */
    private static function _save($path, $code) {       
        if ( ! is_writable(dirname($path)) ){
            throw new Exception('Каталог ' . $path . ' не доступен для записи');
        }
        file_put_contents($path, $code);      
        return $path;
    }
    
    /**
     * Проверка подключаемого файла
     * @param array $inc_array Массив подключаемых файлов
     * @throws Exception
     */
    private static function _check($inc_array){
        foreach ($inc_array as $v) {
            if (!is_file($v)) {
                throw new Exception('Файл ' . $v . ' не найден!');
            }
        }
    }

}

