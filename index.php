<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.10.2018
 * Time: 23:15
 */

require __DIR__."/services/App.php";

$controller = (new \Controllers\ParserController());

$controller->actionEveryMonth();

$controller->actionEverYear();