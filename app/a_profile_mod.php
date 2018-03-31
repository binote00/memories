<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 01-12-17
 * Time: 10:06
 */
require_once '../inc/actions.inc.php';

if(isset($_POST) and isset($_SESSION['id'])){
    $user = new User();
    $ok = $user->updateUser($_SESSION['id'], $_POST);
}
if($ok){
    Output::ShowAlert(TXT_PROFILE_MOD_DONE, 'success');
}else{
    Output::ShowAlert(TXT_PROFILE_MOD_FAIL, 'danger');
}
header('Location: ../index.php?view=profile');