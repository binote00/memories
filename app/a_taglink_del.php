<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 14-01-18
 * Time: 11:02
 */
require_once '../inc/actions.inc.php';

$redirect = 'index';
if(isset($_POST['id']) && isset($_POST['redirect'])){
    $redirect = $_POST['redirect'];
    $tag = new Tag();
    $ok = $tag->delTagLink($_POST['id']);
    if($ok){
        $alert = Output::ShowAdvert(TXT_TAG_DEL_DONE, 'success');
    }else{
        $alert = Output::ShowAdvert(TXT_TAG_DEL_FAIL, 'danger');
    }
}
echo $alert;
//header('Location: ../index.php?view='.$redirect);