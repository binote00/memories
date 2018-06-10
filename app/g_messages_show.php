<?php
/**
 *
 * User: JF
 * Date: 25-11-17
 * Time: 12:35
 */
require_once '../inc/actions.inc.php';

if(isset($_SESSION)){
    if($_SESSION['id']) {
        /*$o_img = '';
        $user = new User();
        $o_img = $user->getImagesFromUser($_SESSION['id']);
        echo $o_img;*/
    }
}