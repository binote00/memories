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
    $content = Output::ShowAdvert('Les Tags (ou étiquettes) sont des mots-clés utilisés pour regrouper les données afin de pouvoir les trier et les rechercher facilement.<br>Vous pouvez créer, modifier et supprimer vos Tags sur cette page.', 'info', true);
    $user = new User();
    $content .= $user->viewTags($_SESSION['id']);

    //Modal Tag
    $redirect = 'tag';
    include_once 'v_modal_tag_add.php';
}