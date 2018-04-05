<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 05-04-18
 * Time: 09:05
 */

require_once '../inc/actions.inc.php';

$ok1 = false;
if (isset($_POST) and isset($_SESSION['id'])) {
    $param = new Param();
    if (array_key_exists('cards_per_page', $_POST)) {
        $ok1 = $param->modParam($_SESSION['id'], 1, $_POST['cards_per_page']);
    } else {
        $ok1 = true;
    }
    if (array_key_exists('event_auto_tag', $_POST)) {
        $ok2 = $param->modParam($_SESSION['id'], 3, $_POST['event_auto_tag']);
    } else {
        $ok2 = true;
    }
}
if (!$ok1 || !$ok2) {
    Output::ShowAlert(TXT_OPTIONS_MOD_FAIL, 'danger');
} else {
    Output::ShowAlert(TXT_OPTIONS_MOD_DONE, 'success');
}
header('Location: ../index.php?view=options');