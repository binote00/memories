<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 21-01-18
 * Time: 08:02
 */

require_once '../inc/actions.inc.php';

if(isset($_GET['chk'])){
    $_SESSION['chk_img_del'] = intval($_GET['chk']);
}