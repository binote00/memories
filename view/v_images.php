<?php
/**
 *
 * User: Binote
 * Date: 30-11-17
 * Time: 14:44
 */

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
} else {
    //Don't delete $redirect !! used in forms
    $redirect = 'images';
    include_once __DIR__ . '/../form/f_images_add.php';
    $content .= Output::ShowAdvert('Les images doivent être de type .jpg ou .png et d\'une taille maximale de 2Mo', 'info', true);
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

    /*$content .= Output::ShowToDo([
        'Supprimer un Tag par élément [Actuellement en test, cliquez sur les #Tags sous les images]'
    ], 'warning', true);*/

    $offset = 1;
    $offset_max = 0;
    if (isset($_SESSION['offset'])) {
        $offset = intval($_SESSION['offset']);
        if ($offset < 1) {
            $offset = 1;
            $_SESSION['offset'] = 1;
        }
    }
    if (isset($_SESSION['offset_max'])) {
        $offset_max = intval($_SESSION['offset_max']);
    }
    $limit = [$offset, CARDS_PER_PAGE];

    $user = new User();
    if (isset($_SESSION['chk_img_del'])) {
        $chk_img_del = intval($_SESSION['chk_img_del']);
        if ($chk_img_del > 0) {
            $img_del = '<div><input type="checkbox" id="chk-img-del" name="chk-img-del" checked> Afficher les images supprimées</div>';
        } else {
            $img_del = '<div><input type="checkbox" id="chk-img-del" name="chk-img-del"> Afficher les images supprimées</div>';
        }
    } else {
        $img_del = '<div><input type="checkbox" id="chk-img-del" name="chk-img-del"> Afficher les images supprimées</div>';
    }
    $img_head = '<div class="row"><div class="col-6"><h2>Vos Images [' . $offset . '/' . $offset_max . ']</h2></div><div class="col-6">' . $img_del . '</div></div>';
    if ($offset > 1) {
        $img_btn .= '<a href="./index.php?view=' . $redirect . '" class="btn btn-primary" id="img-prec">' . TXT_PREV . '</a>';
    }
    if ($offset < 2 || $offset < $offset_max) {
        $img_btn .= '<a href="./index.php?view=' . $redirect . '" class="btn btn-primary" id="img-next">' . TXT_NEXT . '</a>';
    }
    $images = $user->getImagesFromUser($_SESSION['id'], 'card', $limit, $chk_img_del);
    if ($images) {
        $content .= $img_head . $img_btn . $images . $img_btn;
    }

    //Modal Tag
    include_once 'v_modal_tag_add.php';
    include_once 'v_modal_img_size.php';
}
