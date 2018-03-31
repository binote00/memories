<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 06-11-17
 * Time: 08:33
 */
session_start();
spl_autoload_register(function ($classe) {
    require_once 'lib/' . $classe . '.php';
});
require_once 'const.inc.php';
$alerts = '';
$content = '';
$o_img = '';
$nav_extends = '';
$view = 'index';

if ($_GET) {
    $view = $_GET['view'];
}
if ($_SESSION) {
    $alerts = $_SESSION['alert'];
    $_SESSION['alert'] = '';
    if ($_SESSION['id']) {
        $nav_extends = '            
            <li class="nav-item">
                <a class="nav-link" href="index.php?view=delog">' . TXT_DELOG . '</a>
            </li>';
    }
}