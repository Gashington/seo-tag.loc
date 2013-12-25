<?php

defined('SYSPATH') or die('No direct script access.');
/**
 * Класс стратегии для распределения действий в зависимости от клиента (ОС, браузер)
 */
abstract class Appstrategy_Appnamingstrategy {
    abstract public function make();
}
