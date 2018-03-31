<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 02-12-17
 * Time: 12:44
 */

if($_SESSION){
    if($_SESSION['id']){
        $form = new Form();
        $modal_body = $form->CreateForm('./app/a_tag_add.php', 'POST', 'Ajouter un Tag')
            ->AddInput('tag_name', 'Nom du Tag', 'text', '', '', '', 'required')
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->AddInput('redirect', '', 'hidden', $redirect)
            ->EndForm('Valider');
    }
}