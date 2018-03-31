<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 13-01-18
 * Time: 15:08
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['id']) && isset($_POST['tag_id'])){
    if($_POST['tag_id'] >0) {
        $event = new Event();
        $ok = $event->setEventTag($_POST['id'], $_POST['tag_id']);
    }
}
if($ok){
    Output::ShowAlert(TXT_EVENT_ADD_DONE, 'success');
}else{
    Output::ShowAlert(TXT_EVENT_ADD_FAIL, 'danger');
}
header('Location: ../index.php?view=event');