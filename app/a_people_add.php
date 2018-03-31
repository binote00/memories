<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 10-11-17
 * Time: 09:58
 */

require_once '../inc/actions.inc.php';

if($_POST){
    $photo = 0;
    if($_FILES){
        if($_FILES['img']['name']){
            $image = new Image();
            $photo = $image->addImage($_POST, $_FILES);
        }
    }
    $user = new People();
    $ok = $user->addPeople($_POST, $photo);
    if($ok){
        Output::ShowAlert(TXT_PEOPLE_ADD_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_PEOPLE_ADD_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=people');