<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 17-01-18
 * Time: 11:43
 */

if(isset($_POST['id']) && isset($_POST['search'])){
    require_once '../inc/actions.inc.php';
    $user = new User();
    $tags = $user->getTags($_POST['id']);
    foreach($tags as $data){
        $pos = strpos($data[1], $_POST['search']);
        if($pos !== false){
            $tag = $data[1];
        }
    }
    echo $tag;
}