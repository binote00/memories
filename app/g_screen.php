<?php
/**
 *
 * User: JF
 * Date: 03-12-17
 * Time: 11:51
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['recordSize'])) {
    $height = $_POST['height'];
    $width = $_POST['width'];
    $_SESSION['screen_height'] = $height;
    $_SESSION['screen_width'] = $width;
}