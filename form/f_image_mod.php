<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 01-12-17
 * Time: 09:36
 */

if($_SESSION){
    if($_SESSION['id']){
        $form = new Form();
        $form_txt = $form->CreateForm('./app/a_images_mod.php','POST', 'Modifier votre image')
            ->AddInput('title', 'Titre')
            ->AddInput('id', '', 'hidden', $_POST['id'])
            ->EndForm('Modifier');
        echo $form_txt;
    }else{
        header('Location: index.php?view=images');
    }
}else{
    header('Location: index.php');
}