<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 24-11-17
 * Time: 10:06
 */

if(!isset($_SESSION['id'])){
    header('Location: index.php');
}else{
//    $content .= Output::ShowToDo([
//        'Envoyer un email aux personnes',
//    ], 'warning', true);
    $people = new People();
    $pers = $people->viewPeople($_SESSION['id']);
    if($pers){
        $content .= '<div class="collapse" id="f-people-add-collapse">';
        include_once __DIR__.'/../form/f_people_add.php';
        $content .= '</div>'.$pers;
    }else{
        include_once __DIR__.'/../form/f_people_add.php';
    }
}