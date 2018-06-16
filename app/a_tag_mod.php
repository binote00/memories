<?php
/**
 *
 * User: Binote
 * Date: 10-01-18
 * Time: 09:10
 */
require_once '../inc/actions.inc.php';

if (isset($_POST)) {
    $tag = new Tag();

    $ok = $tag->modTag($_POST);
    if ($ok) {
        Output::ShowAlert(TXT_TAG_MOD_DONE, 'success');
    } else {
        Output::ShowAlert(TXT_TAG_EXIST, 'danger');
    }
}
header('Location: ../index.php?view=tag');