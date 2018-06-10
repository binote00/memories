<?php
/**
 *
 * User: JF
 * Date: 19-05-18
 * Time: 10:58
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['id']) && isset($_POST['title'])){
    $event = new Event();
    $ok = $event->updateEvent($_POST['id'], 'title', $_POST['title']);
    if($ok){
        Output::ShowAlert(TXT_EVENT_MOD_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_EVENT_MOD_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=event');