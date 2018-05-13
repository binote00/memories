<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 13-05-18
 * Time: 19:55
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['id']) && isset($_POST['event_id'])){
    $msg = new Message();
    $ok = $msg->updateMessageEvent($_POST['id'], $_POST['event_id']);
    if($ok){
        Output::ShowAlert(TXT_MESSAGE_NOTE_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_MESSAGE_NOTE_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=message');