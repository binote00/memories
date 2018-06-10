<?php
/**
 *
 * User: Binote
 * Date: 10-01-18
 * Time: 09:10
 */
require_once '../inc/actions.inc.php';

if(isset($_POST['id'])){
    $tag = new Tag();
    $ok = $tag->delTag($_POST['id']);
    if($ok){
        Output::ShowAlert(TXT_TAG_DEL_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_TAG_DEL_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=tag');