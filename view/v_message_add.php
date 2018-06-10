<?php
/**
 *
 * User: Binote
 * Date: 16-11-17
 * Time: 14:47
 */
if(!isset($_SESSION['id'])){
    header('Location: index.php');
}else{
    include_once __DIR__.'/../form/f_message_add.php';
    $user = new User();
    $souvenirs = $user->getEventsFromUser($_SESSION['id'], 1);
    $content =
        '<div class="row">
        <div class="col-lg-4 col-12">
            '.$form_add.'
        </div>
        <div class="col-lg-8 col-12">
            '.$souvenirs.'
        </div>
    </div>';
}