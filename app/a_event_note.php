<?php
/**
 *
 * User: Binote
 * Date: 15-01-18
 * Time: 10:54
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['id']) && isset($_POST['note'])){
    $event = new Event();
    $ok = $event->updateEvent($_POST['id'], 'note', $_POST['note']);
    if($ok){
        Output::ShowAlert(TXT_EVENT_NOTE_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_EVENT_NOTE_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=event');