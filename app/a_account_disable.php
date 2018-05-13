<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 13-05-18
 * Time: 18:38
 */

require_once '../inc/actions.inc.php';

if(isset($_POST) and isset($_SESSION['id'])){
    $user = new User();
    $ok = $user->deleteUser($_SESSION['id']);
}
if($ok){
    Output::ShowAlert(TXT_PROFILE_MOD_DONE, 'success');
}else{
    Output::ShowAlert(TXT_PROFILE_MOD_FAIL, 'danger');
}
session_destroy();
session_commit();
header('Location: ../index.php');