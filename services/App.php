<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.10.2018
 * Time: 21:36
 */

require_once __DIR__."/Autoloader.php";
spl_autoload_register([new \services\Autoloader(), "loadClass"]);
require_once __DIR__. '/../vendor/autoload.php';
