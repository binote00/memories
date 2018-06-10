<?php
/**
 *
 * User: Binote
 * Date: 08-12-17
 * Time: 14:26
 */

if(!isset($_SESSION['id'])){
    header('Location: index.php');
}else{
    $user = new User();
    $images = $user->getImagesFromUserByTag($_SESSION['id'], $_POST['text']);
    $messages = $user->getMessagesFromUserByTag($_SESSION['id'], $_POST['text']);
    $content .= $images;
    if($messages){
        $content.='<hr class="style">'.$messages;
    }
}