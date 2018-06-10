<?php
/**
 *
 * User: Binote
 * Date: 01-12-17
 * Time: 10:06
 */
require_once '../inc/actions.inc.php';

$image = new Image();
$ok = $image->modImage($_POST);
if($ok){
    Output::ShowAlert(TXT_IMAGE_MOD_DONE, 'success');
}else{
    Output::ShowAlert(TXT_IMAGE_MOD_FAIL, 'danger');
}
header('Location: ../index.php?view=images');