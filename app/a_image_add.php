<?php
/**
 *
 * User: Binote
 * Date: 16-11-17
 * Time: 14:49
 */
require_once '../inc/actions.inc.php';

$image = new Image();
$ok = $image->addImage($_POST,$_FILES);
if($ok){
    Output::ShowAlert(TXT_IMAGE_ADD_DONE, 'success');
}else{
    Output::ShowAlert(TXT_IMAGE_ADD_FAIL, 'danger');
}
header('Location: ../index.php?view=images');