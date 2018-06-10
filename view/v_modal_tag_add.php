<?php
/**
 *
 * User: Binote
 * Date: 16-11-17
 * Time: 14:47
 */
if(isset($_SESSION['id'])){
    include_once __DIR__.'/../form/f_tag_add.php';
    if($modal_body){
        $content .= Output::viewModal('modal-add-btn','#Tag', $modal_body, '');
    }
}
