<?php
/**
 *
 * User: Binote
 * Date: 16-11-17
 * Time: 14:49
 */
require_once '../inc/actions.inc.php';

$image = new Image();
$ok = $image->addImages($_POST, $_FILES);
if ($ok) {
    Output::ShowAlert('Images ajoutées avec succès!', 'success');
} else {
    Output::ShowAlert('Erreur dans l\'ajout des images!', 'danger');
}
header('Location: ../index.php?view=images');