<?php
/**
 *
 * User: Binote
 * Date: 30-11-17
 * Time: 11:53
 */

if(!isset($_SESSION['id'])){
    header('Location: index.php');
}else{
//    $content .= Output::ShowToDo([
//        'Ajouter un lieu via API Google',
//    ], 'warning', true);
    $user = new User();
    $events = $user->getEventsFromUser($_SESSION['id']);
    if($events){
        $content .= '<div class="collapse" id="f-event-add-collapse">';
        include_once __DIR__.'/../form/f_event_add.php';
        $content .= '</div>'.$events;
    }else{
        include_once __DIR__.'/../form/f_event_add.php';
    }

    //Modal Tag
    $redirect = 'event';
    include_once 'v_modal_tag_add.php';
}
/**
 * https://developers.google.com/maps/documentation/javascript/mysql-to-maps?hl=fr
 * https://developers.google.com/maps/documentation/javascript/places
 */