<?php
/**
 *
 * User: Binote
 * Date: 30-11-17
 * Time: 14:45
 */

if ($_SESSION) {
    if ($_SESSION['id']) {
        $form = new Form();
        $content .= $form->CreateForm('./app/a_people_add.php', 'POST', 'Ajouter une personne', true)
            ->AddInput('first_name', 'Prénom', 'text', '', '', '', 'required')
            ->AddInput('last_name', 'Nom', 'text', '', '', '', 'required')
            ->AddInput('nickname', 'Surnom')
            ->AddInput('birth_date', 'Date de Naissance', 'date')
            ->AddInput('email', 'Email', 'email')
            ->AddSelect('photolist', 'Photo depuis votre collection d\'Images', 'image', ['id', 'link', 'title', 'status'], ['OR', 'title', 'link'], 'id', ['uploader', 'status'], [$_SESSION['id'], '0'], 'title', 'ASC')
            ->AddInput('img', 'Photo importée depuis votre ordinateur', 'file')
            ->AddInput('title', '', 'hidden', '')
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->EndForm('Valider');
    }
}