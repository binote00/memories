<?php
/**
 *
 * User: Binote
 * Date: 16-11-17
 * Time: 14:49
 */
require_once '../inc/actions.inc.php';

$event = new Message();
$ok = $event->setMessageTag($_POST['id'], $_POST['tag_id']);
if($ok){
    Output::ShowAlert('Tag ajouté avec succès!', 'success');
}else{
    Output::ShowAlert('Erreur dans l\'ajout du tag!', 'danger');
}
header('Location: ../index.php?view=message');