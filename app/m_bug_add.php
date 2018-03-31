<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 13-01-18
 * Time: 13:08
 */

require_once '../inc/actions.inc.php';

if($_POST){
    $msg = 'user_id = '.$_POST['user_id'].' // '.$_POST['desc'].' // '.$_POST['error'];
    mail(LOG_EMAIL, '[MEMORIES : Bug]', $msg);
}