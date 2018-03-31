<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 16-11-17
 * Time: 14:47
 */
if(!isset($_SESSION['id'])){
    header('Location: index.php');
}else{
    $form_add = '';
    include_once __DIR__.'/../form/f_journal_add.php';
    if(isset($_SESSION['ajax'])){
        $o_img = 'toto'; //$_SESSION['ajax'];
    }
    $content =
        '<div class="row">
            <div class="col-lg-4 col-12">
                '.$form_add.'
            </div>
            <div class="col-lg-8 col-12" id="events">
            </div>
        </div>
        <div id="o_img">'.$o_img.'</div>';
}
