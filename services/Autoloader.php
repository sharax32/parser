<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.10.2018
 * Time: 21:36
 */

namespace Services;


class Autoloader
{
    function loadClass($classname){
        $classname = str_replace("app\\", $_SERVER['DOCUMENT_ROOT']."/", $classname);
        $classname = str_replace("\\","/",$classname.".php");
        if(file_exists($classname)){
            require $classname;
        }
    }
}