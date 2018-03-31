<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 11-01-18
 * Time: 09:47
 */

require_once '../inc/actions.inc.php';

$msg = new Message();
$ok = $msg->updateMessage($_POST);
if($ok){
    $alert = Output::ShowAdvert(TXT_MESSAGE_MOD_DONE, 'success');
}else{
    $alert = Output::ShowAdvert(TXT_MESSAGE_MOD_FAIL, 'danger');
}
echo $alert;
//header('Location: ../index.php?view=message');