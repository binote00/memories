<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 30-11-17
 * Time: 14:45
 */

if($_SESSION){
    if($_SESSION['id']){
        $form = new Form();
        $user = new User();
        $user->getUser($_SESSION['id']);

        $content = $form->CreateForm('./app/a_images_add.php','POST', 'Ajouter des images', true)
            ->AddInput('img[]', 'Images', 'file', '', '', '', 'required multiple')
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->EndForm('Valider');
    }else{
        header('Location: index.php');
    }
}else{
    header('Location: index.php');
}