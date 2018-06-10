<?php
/**
 *
 * User: JF
 * Date: 13-01-18
 * Time: 13:03
 */

if(!isset($_SESSION['id'])){
    Output::ShowAlert(TXT_REGISTER_ALERT, 'warning');
    header('Location: index.php');
}else{
    include_once __DIR__.'/../form/f_bug.php';
}