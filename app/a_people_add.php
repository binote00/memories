<?php
/**
 *
 * User: Binote
 * Date: 10-11-17
 * Time: 09:58
 */

require_once '../inc/actions.inc.php';

if ($_POST) {
    $photo = 0;
    $mod_people = false;
    $fail_msg = TXT_PEOPLE_MOD_FAIL;

    if (empty($_POST['photolist']) && $_FILES) {
        if ($_FILES['img']['name']) {
            $image = new Image();
            $photo = $image->addImage($_POST, $_FILES);
        }
    }
    if (empty($_POST['photolist'])) {
        $mod_people = true;
    } elseif (!empty($_POST['photolist'])) {
        $mod_people = true;
        $photo = $_POST['photolist'];
    } else {
        $fail_msg .= '<br>L\'image choisie n\'est pas valide';
    }
    if ($mod_people == true) {
        $user = new People();
        $ok = $user->addPeople($_POST, $photo);
    }
    if ($ok) {
        Output::ShowAlert(TXT_PEOPLE_ADD_DONE, 'success');
    } else {
        Output::ShowAlert(TXT_PEOPLE_ADD_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=people');