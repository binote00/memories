<?php
/**
 *
 * User: Binote
 * Date: 30-11-17
 * Time: 14:44
 */

if(!isset($_SESSION['id'])){
    header('Location: index.php');
}else{
    //Don't delete $redirect !! used in forms
    $redirect = 'images_add';
    include_once __DIR__.'/../form/f_images_add.php';
    /*$offset_max = 0;
    $page = 0;
    if(isset($_SESSION['offset'])){
        $offset = intval($_SESSION['offset']);
        if(isset($_SESSION['offset_max'])){
            $offset_max = intval($_SESSION['offset_max']);
        }
        if($offset <0){
            $_SESSION['offset'] = 0;
            $offset = 0;
        }elseif($offset_max && ($offset + 8) > $offset_max){
            $_SESSION['offset'] = $offset_max - 8;
            $offset = $offset_max - 8;
        }
        $page = ceil($offset / IMAGES_PER_PAGE);
        $limit = [$offset,IMAGES_PER_PAGE];
    }else{
        $limit = [0,IMAGES_PER_PAGE];
    }*/
    $offset =1;
    $offset_max =0;
    if(isset($_SESSION['offset'])){
        $offset = intval($_SESSION['offset']);
        if($offset <1){
            $offset=1;
            $_SESSION['offset']=1;
        }
    }
    if(isset($_SESSION['offset_max'])){
        $offset_max = intval($_SESSION['offset_max']);
    }
    $limit = [$offset,IMAGES_PER_PAGE];
    $user = new User();
    $content .= '<h2>Vos Images ['.$offset.'/'.$offset_max.']</h2>';
    if($offset >1){
        $content .= '<a href="./index.php?view='.$redirect.'" class="btn btn-primary-1" id="img-prec">Précédent</a>';
    }
    if($offset <2 || $offset < $offset_max){
        $content .= '<a href="./index.php?view='.$redirect.'" class="btn btn-primary-1" id="img-next">Suivant</a>';
    }
    $content .= $user->getImagesFromUser($_SESSION['id'], 'card', $limit);

    //Modal
    include_once __DIR__.'/../form/f_tag_add.php';
    $content .= Output::viewModal('modal-add-btn','#Tag', $modal_body, '');
}