<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 21-01-18
 * Time: 13:37
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['id'])) {
    $image = new Image();
    $ok = $image->restoreImage($_POST['id']);
}
if($ok){
    Output::ShowAlert(TXT_IMAGE_REST_DONE, 'success');
}else{
    Output::ShowAlert(TXT_IMAGE_REST_FAIL, 'danger');
}
header('Location: ../index.php?view=images');