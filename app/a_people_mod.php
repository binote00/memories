<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 19-01-18
 * Time: 11:21
 */

require_once '../inc/actions.inc.php';

if($_POST){
    $photo = $_POST['photo'];
    if($_FILES){
        if($_FILES['img']['name']){
            $image = new Image();
            $photo = $image->addImage($_POST, $_FILES);
        }
    }
    var_dump(get_defined_vars());
    $user = new People();
    $ok = $user->modPeople($_POST, $photo);
    if($ok){
        Output::ShowAlert(TXT_PEOPLE_MOD_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_PEOPLE_MOD_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=people');