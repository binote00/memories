<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 10-01-18
 * Time: 13:40
 */
require_once '../inc/actions.inc.php';

if(isset($_POST['tag_id']) && isset($_POST['id'])){
    $tag = new Tag();
    $ok = $tag->TransferTag($_POST['id'], $_POST['tag_id']);
    if($ok){
        Output::ShowAlert(TXT_TAG_TR_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_TAG_TR_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=tag');