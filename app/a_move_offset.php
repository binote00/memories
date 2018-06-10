<?php
/**
 *
 * User: Binote
 * Date: 01-12-17
 * Time: 12:00
 */

require_once '../inc/actions.inc.php';

if (isset($_GET['move'])) {
    $_SESSION['offset'] += intval($_GET['move']);
    if (intval($_SESSION['offset'] < 1)) {
        $_SESSION['offset'] = 1;
    }
    return $_SESSION['offset'];
}
