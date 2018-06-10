<?php
/**
 *
 * User: Binote
 * Date: 10-11-17
 * Time: 09:58
 */

spl_autoload_register(function($classe){
    require_once '../lib/'.$classe.'.php';
});

if($_POST){
    $user = new User();
    $user->addUser($_POST);
}
header('Location: ../index.php');