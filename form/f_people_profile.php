<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 24-11-17
 * Time: 11:54
 */

if(isset($people_id)){

    $form = new Form();
    $user = new People();
    $user->getPeople($people_id);

    $form_add = $form->CreateForm('./app/a_people_add.php', 'POST', 'Profil de la personne', true)
        ->AddInput('first_name', 'Prénom')
        ->AddInput('last_name', 'Nom')
        ->AddInput('nickname', 'Surnom')
        ->AddInput('birth_date', 'Date de Naissance', 'date')
        ->AddInput('email', 'Email', 'email')
        ->AddInput('photo', 'Photo', 'file')
        ->AddInput('title', '', 'hidden', '')
        ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
        ->EndForm('Valider');
}