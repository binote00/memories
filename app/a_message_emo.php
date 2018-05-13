<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 13-05-18
 * Time: 20:08
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['id']) && isset($_POST['emotion'])){
    $msg = new Message();
    $ok = $msg->updateMessageEmotion($_POST['id'], $_POST['emotion']);
    if($ok){
        Output::ShowAlert(TXT_MESSAGE_NOTE_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_MESSAGE_NOTE_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=message');