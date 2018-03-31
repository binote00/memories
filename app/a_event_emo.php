<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 15-01-18
 * Time: 10:54
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['id']) && isset($_POST['emotion'])){
    $event = new Event();
    $ok = $event->updateEvent($_POST['id'], 'emotion', $_POST['emotion']);
    if($ok){
        Output::ShowAlert(TXT_EVENT_MOD_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_EVENT_MOD_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=event');