<?php
/**
 *
 * User: Binote
 * Date: 01-12-17
 * Time: 09:36
 */

if($_SESSION){
    if($_SESSION['id']){
        $form = new Form();
        $form_txt = $form->CreateForm('./app/a_image_mod.php','POST', 'Modifier votre image')
            ->AddInput('title', 'Titre')
            ->AddInput('id', '', 'hidden', $_POST['id'])
            ->AddSelect('event_id', 'Evénement', 'event', ['id', 'moment', 'title'], ['moment', 'title'], 'id', 'user_id', $_SESSION['id'], 'moment', 'DESC', true)
            ->EndForm('Modifier');
        echo $form_txt;
    }else{
        header('Location: index.php?view=images');
    }
}else{
    header('Location: index.php');
}