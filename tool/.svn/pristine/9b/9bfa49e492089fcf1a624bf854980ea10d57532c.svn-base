<?php

/**
* Config.php
* 
* Config class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 15/7/2015
* @time 19:54
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Core_Config{
    
    public function __construct(){
        
    }
    
    public static function getConfig($section, $key){
        $ini = new Core_Ini(CONFIG_DIR.DS.'config.ini');
        
        return $ini->getValue($section,$key);
    }

    public static function saveConfig($fileName, $iniArray){
        $ini = new Core_Ini();
        $ini->_iniParsedArray = $iniArray;
        return $ini->save($fileName);
    }
}