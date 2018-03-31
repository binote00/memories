<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 17-01-18
 * Time: 10:16
 */

if(isset($_POST['id'])){
    require_once '../inc/actions.inc.php';
    $user = new User();
    $tags = $user->getTags($_POST['id']);
    echo json_encode($tags);
}
