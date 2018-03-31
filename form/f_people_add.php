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
        $content .= $form->CreateForm('./app/a_people_add.php', 'POST', 'Ajouter une personne', true)
            ->AddInput('first_name', 'Prénom', 'text', '', '', '', 'required')
            ->AddInput('last_name', 'Nom', 'text', '', '', '', 'required')
            ->AddInput('nickname', 'Surnom')
            ->AddInput('birth_date', 'Date de Naissance', 'date')
            ->AddInput('email', 'Email', 'email')
            ->AddInput('img', 'Photo', 'file')
            ->AddInput('title', '', 'hidden', '')
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->EndForm('Valider');
    }
}