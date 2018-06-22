<?php
/**
 *
 * User: JF
 * Date: 19-01-18
 * Time: 11:21
 */

require_once '../inc/actions.inc.php';

if ($_POST) {
    $ok = false;
    $mod_people = false;
    $fail_msg = TXT_PEOPLE_MOD_FAIL;
    $photo = $_POST['photo'];

    if (empty($_POST['photolist']) && $_FILES) {
        if ($_FILES['img']['name']) {
            $image = new Image();
            $photo = $image->addImage($_POST, $_FILES);
        }
    }
    if (!empty($_POST['photolist'])) {
        $mod_people = true;
        $photo = $_POST['photolist'];
    } elseif (!empty($photo)) {
        $mod_people = true;
    } else {
        $fail_msg .= '<br>L\'image choisie n\'est pas valide';
    }
    if ($mod_people == true) {
        $user = new People();
        $ok = $user->modPeople($_POST, $photo);
    }
    if ($ok) {
        Output::ShowAlert(TXT_PEOPLE_MOD_DONE, 'success');
    } else {
        Output::ShowAlert($fail_msg, 'danger');
    }
}
header('Location: ../index.php?view=people');