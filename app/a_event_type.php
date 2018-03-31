<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 15-01-18
 * Time: 12:01
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['id']) && isset($_POST['event_type'])){
    $event = new Event();
    $ok = $event->updateEvent($_POST['id'], 'event_type', $_POST['event_type']);
    if($ok){
        Output::ShowAlert(TXT_EVENT_MOD_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_EVENT_MOD_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=event');