<?php
/**
 *
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
                <a class="nav-link" href="index.php?view=profile">' . TXT_PROFILE . '</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="nav-drop-diary" data-toggle="dropdown">
                Journal
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item text-capitalize" href="index.php?view=event">' . TXT_EVENT . '</a>
                    <a class="dropdown-item text-capitalize" href="index.php?view=images">' . TXT_IMAGE  . '</a>
                    <a class="dropdown-item text-capitalize" href="index.php?view=message">' . TXT_MESSAGE  . '</a>
                    <a class="dropdown-item text-capitalize" href="index.php?view=people">' . TXT_PEOPLE  . '</a>
                    <a class="dropdown-item text-capitalize" href="index.php?view=tag">' . TXT_TAG  . '</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="nav-drop-tools" data-toggle="dropdown">
                    Outils
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item text-capitalize" href="index.php?view=timeline">' . TXT_TIMELINE . '</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?view=options">' . TXT_OPTIONS . '</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?view=delog">' . TXT_DELOG . '</a>
            </li>';
    }
}