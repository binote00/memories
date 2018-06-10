<?php
/**
 *
 * User: JF
 * Date: 12-01-18
 * Time: 11:40
 */

require_once '../inc/actions.inc.php';

$image = new Image();
$ok = $image->delImage($_POST);
if($ok){
    Output::ShowAlert(TXT_IMAGE_DEL_DONE, 'success');
}else{
    Output::ShowAlert(TXT_IMAGE_DEL_FAIL, 'danger');
}
header('Location: ../index.php?view=images');