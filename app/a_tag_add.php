<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 16-11-17
 * Time: 14:49
 */
require_once '../inc/actions.inc.php';

$tag = new Tag();
$ok = $tag->addTag($_POST);
if($ok){
    Output::ShowAlert(TXT_TAG_ADD_DONE, 'success');
}else{
    Output::ShowAlert(TXT_TAG_EXIST, 'danger');
}
if($_POST['redirect']){
    header('Location: ../index.php?view='.$_POST['redirect']);

}else{
    header('Location: ../index.php');
}