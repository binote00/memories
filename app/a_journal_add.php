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
    Output::ShowAlert('Evènement ajouté avec succès!', 'success');
}else{
    Output::ShowAlert('Erreur dans l\'ajout d\'évènement!', 'danger');
}
header('Location: ../index.php?view=journal_add');