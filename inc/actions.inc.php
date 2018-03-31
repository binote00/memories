<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 17-11-17
 * Time: 10:21
 */
session_start();
require_once 'const.inc.php';
spl_autoload_register(function ($classe) {
    require_once '../lib/' . $classe . '.php';
});
