<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 12-01-18
 * Time: 11:58
 */

require_once '../inc/actions.inc.php';

$event = new Event();
$ok = $event->addEvent($_POST);
if($ok){
    Output::ShowAlert(TXT_EVENT_ADD_DONE, 'success');
}else{
    Output::ShowAlert(TXT_EVENT_ADD_FAIL, 'danger');
}
header('Location: ../index.php?view=event');