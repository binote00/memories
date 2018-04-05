<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 05-04-18
 * Time: 09:05
 */

require_once '../inc/actions.inc.php';

if(isset($_POST) and isset($_SESSION['id'])){
    $user = new Param();
    $ok = $user->modParam($_SESSION['id'], $_POST);
}
if($ok){
    Output::ShowAlert(TXT_OPTIONS_MOD_DONE, 'success');
}else{
    Output::ShowAlert(TXT_OPTIONS_MOD_FAIL, 'danger');
}
header('Location: ../index.php?view=options');