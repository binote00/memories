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
    $content .= Output::ShowToDo([
        'Afficher les émotions',
    ], 'warning', true);
    $user = new User();
    $messages = $user->getMessagesFromUser($_SESSION['id'], 1);
    if($messages){
        $content .= '<div class="collapse" id="f-message-add-collapse">';
        include_once __DIR__.'/../form/f_message_add.php';
        $content .= '</div>'.$messages;
    }else{
        include_once __DIR__.'/../form/f_message_add.php';
    }

    //Modal Tag
    $redirect = 'message';
    include_once 'v_modal_tag_add.php';
}