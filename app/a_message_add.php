<?php
/**
 *
 * User: Binote
 * Date: 16-11-17
 * Time: 14:49
 */
require_once '../inc/actions.inc.php';

$event = new Message();
$ok = $event->setMessageInfos($_POST);
if($ok){
    Output::ShowAlert(TXT_MESSAGE_ADD_DONE, 'success');
}else{
    Output::ShowAlert(TXT_MESSAGE_ADD_FAIL, 'danger');
}
header('Location: ../index.php?view=message');