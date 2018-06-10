<?php
/**
 *
 * User: Binote
 * Date: 15-01-18
 * Time: 10:54
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['id']) && isset($_POST['note'])){
    $msg = new Message();
    $ok = $msg->updateMessageNote($_POST['id'], $_POST['note']);
    if($ok){
        Output::ShowAlert(TXT_MESSAGE_NOTE_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_MESSAGE_NOTE_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=message');